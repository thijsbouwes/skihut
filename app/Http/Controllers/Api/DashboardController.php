<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $data = [];
        // events
        $data['future_event_count'] = Event::whereDate('event_date', '>=', Carbon::now())->count();
        $data['past_event_count'] = Event::whereDate('event_date', '<', Carbon::now())->count();

        // stock
        $data['products_in_stock'] = Product::has('stocks')->get()->filter(function($product) {
            return $product->in_stock_quantity > 0;
        });

        // payments
        $users = User::whereHas('events', function($query) {
            $query->where('payed', '=', false);
        })->get();

        $data['outstanding_money'] = 100;
        $data['revenue'] = 200;

        return new JsonResponse($data);
    }
}
