<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ListController extends Controller
{
    public function viewList(Request $request)
    {
        $products = null;

        if (!$request->page) {
            // おすすめ
            $products = Product::all();
        } else {
            // マイリスト

        }

        return view('list', compact('products'));
    }
}
