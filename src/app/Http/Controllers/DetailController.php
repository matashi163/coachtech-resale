<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DetailController extends Controller
{
    public function viewDetail($item_id)
    {
        $product = Product::with('condision')->find($item_id);

        return view('detail', compact('product'));
    }
}
