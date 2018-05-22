<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StockRequest;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class StockResource extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $stocks = Stock::orderBy('order_date', 'DESC')->paginate();

        return new JsonResponse($stocks);
    }

    /**
     * Display the specified resource.
     * @param Stock $stock
     * @return JsonResponse
     */
    public function show(Stock $stock)
    {
        return new JsonResponse($stock);
    }

    /**
     * Store a newly created resource in storage.
     * @param StockRequest $createRequest
     * @return JsonResponse
     */
    public function store(StockRequest $createRequest)
    {
        $stock = Stock::create(
            $createRequest->all()
        );

        $this->syncProducts($createRequest->get('products'), $stock);

        return new JsonResponse($stock, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage
     * @param Stock $stock
     * @param StockRequest $updateRequest
     * @return JsonResponse
     */
    public function update(Stock $stock, StockRequest $updateRequest)
    {
        $stock->update(
            $updateRequest->all()
        );

        $this->syncProducts($updateRequest->get('products'), $stock);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     * @param Stock $stock
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $products_request
     * @param $stock
     */
    private function syncProducts($products_request, $stock)
    {
        // create product expenses
        $products = collect($products_request)->mapWithKeys(function($product) {
            return [
                $product['id'] => [
                    'quantity' => $product['quantity']
                ]
            ];
        })->toArray();

        $stock->products()->sync($products);
    }
}
