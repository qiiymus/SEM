<?php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'product_id',
        'product_name',
        'product_cost',
        'product_price',
        'product_quantity',
        'product_category',
        'product_brand',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
