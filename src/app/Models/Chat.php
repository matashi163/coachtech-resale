<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'trading_product_id',
        'user_id',
        'text',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
