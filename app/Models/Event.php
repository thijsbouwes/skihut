<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $appends = [
        'total_products_price',
        'total_revenue',
        'profit',
        'total_users'
    ];

    protected $with = [
        'products',
        'users'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'event_date'
    ];

    /**
     * Get all the users for the Event.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('payed_price', 'payed_date')
            ->withTimestamps();
    }

    /**
     * Get the event products.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getTotalUsersAttribute()
    {
        return $this->users->count();
    }

    public function getTotalProductsPriceAttribute()
    {
        return $this->products->sum(function($product) {
            return $product->price * $product->quantity;
        });
    }

    public function getTotalRevenueAttribute()
    {
        return $this->users->count() * $this->price;
    }

    public function getProfitAttribute()
    {
        return $this->total_revenue - $this->total_products_price;
    }
}
