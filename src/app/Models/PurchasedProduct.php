<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buying_user_id',
        'zip_code',
        'address',
        'building',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
