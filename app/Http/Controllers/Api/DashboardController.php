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
        $products = Product::has('stocks')->with(['stocks', 'events'])->get();

        $data['products_in_stock'] = $products->sum('in_stock_quantity');
        $data['products_in_stock_price'] = $products->map(function($product) {
            return $product->price * $product->in_stock_quantity;
        })->sum();

        // events
        $events = Event::has('users')->with(['users', 'products'])->get();

        $data['profit'] = $events->sum('profit');
        $data['outstanding_money'] = User::has('events')->get()->sum('debt');

        return new JsonResponse($data);
    }
}
