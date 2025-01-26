<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'brand',
        'price',
        'description',
        'category_id',
        'condision_id',
        'selling_user_id',
        'buying_user_id',
    ];

    public function condision()
    {
        return $this->belongsTo(Condision::class);
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class);
    }
}
