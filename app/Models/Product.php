<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = [
        'quantity'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price'
    ];

    /**
     * Get the expenses for the product.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Get the stocks for the product.
     */
    public function stocks()
    {
        return $this->belongsToMany(Stock::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Get the quantity.
     *
     * @return string
     */
    public function getQuantityAttribute()
    {
        if ($this->pivot) {
            return $this->pivot->quantity;
        }

        return 1;
    }
}
