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
            $products = Product::whereHas('bookmark', function ($query) {
                $query->where('user_id', auth()->id());
            })->get();
        }

        return view('list', compact('products'));
    }
}
