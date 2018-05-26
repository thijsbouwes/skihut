<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = [
        'quantity',
        'in_stock_quantity',
        'quantity_used'
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

    public function getInStockQuantityAttribute()
    {
        $quantity_used = $this->events()->sum('quantity');
        $quantity_available = $this->stocks()->sum('quantity');

        return $quantity_available - $quantity_used;
    }

    public function getQuantityUsedAttribute()
    {
        return $this->events()->sum('quantity');
    }

    /**
     * Get the quantity, from stock or event depending on the relation.
     * Default return 1
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
