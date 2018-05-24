<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
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
        //$products = Product::all();
        $data['products_in_stock'] = 10;
        $data['products_in_stock_price'] = 100;

        // payments
        $data['outstanding_money'] = 100;
        $data['revenue'] = 200;

        return new JsonResponse($data);
    }
}
