<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'payment_method',
        'cash_amount',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
