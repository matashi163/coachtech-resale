<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchased_product_id',
        'selling_user_id',
        'buying_user_id',
        'selling_user_seeTime',
        'buying_user_seeTime',
        'selling_user_rate',
        'buying_user_rate',
        'completion',
    ];

    public function chat()
    {
        return $this->hasMany(Chat::class, 'trading_product_id');
    }
}
