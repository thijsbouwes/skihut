<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $with = [
        'products'
    ];

    protected $appends = [
        'total_products_price',
        'total_quantity'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'order_date'
    ];

    /**
     * Get the event products.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getTotalQuantityAttribute()
    {
        return $this->products->sum(function($product) {
            return $product->quantity;
        });
    }

    public function getTotalProductsPriceAttribute()
    {
        return $this->products->sum(function($product) {
            return $product->price * $product->quantity;
        });
    }
}
