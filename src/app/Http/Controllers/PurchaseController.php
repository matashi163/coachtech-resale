<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function viewPurchase($item_id)
    {
        $product = Product::find($item_id);

        return view('purchase', compact('product'));
    }
}
