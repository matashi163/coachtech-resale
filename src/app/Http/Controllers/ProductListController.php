<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductListController extends Controller
{
    public function viewProductList(Request $request)
    {
        if (!$request->page) {
            // おすすめ

        } else {
            // マイリスト

        }
        return view('index');
    }
}
