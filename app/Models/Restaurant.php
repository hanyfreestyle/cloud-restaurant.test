<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the categories associated with the restaurant.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the products associated with the restaurant.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the tables associated with the restaurant.
     */
    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    /**
     * Get the orders associated with the restaurant.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
