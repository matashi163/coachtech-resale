<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\PurchasedProduct;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'first_login',
    ];

    public function purchasedProducts()
    {
        return $this->hasMany(PurchasedProduct::class, 'buying_user_id');
    }
}