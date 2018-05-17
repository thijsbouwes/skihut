<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
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
        'price'
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
}
