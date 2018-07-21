<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = [];
        $year = $request->input('year');
        $month = $request->input('month');

        // stock
        $products = Product::has('stocks')->with(['stocks', 'events'])->get();

        $data['products_in_stock'] = $products->sum('in_stock_quantity');
        $data['products_in_stock_price'] = $products->map(function($product) {
            return $product->price * $product->in_stock_quantity;
        })->sum();

        // events
        $events = Event::has('users')->with(['users', 'products']);

        // filter
        if ($year) {
            $events = $events->whereYear('event_date', $year);
        }
        if ($year && $month) {
            $events = $events->whereMonth('event_date', $month);
        }

        $data['profit'] = $events->get()->sum('profit');
        $data['outstanding_money'] = $events->get()->sum('total_debt');

        // events
        $data['future_event_count'] = Event::whereDate('event_date', '>=', Carbon::now())->count();
        $data['total_event_count'] = $events->get()->count();

        return new JsonResponse($data);
    }
}
