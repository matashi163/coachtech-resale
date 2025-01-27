<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ListController extends Controller
{
    public function viewList(Request $request)
    {
        $pageCheck = $request->page;

        if (!$pageCheck) {
            // おすすめ
            $products = Product::all();
        } else {
            // マイリスト
            $products = Product::whereHas('bookmark', function ($query) {
                $query->where('user_id', auth()->id());
            })->get();
        }

        return view('list', compact('pageCheck', 'products'));
    }

    public function search(Request $request)
    {
        $pageCheck = $request->page;

        $products = Product::where('name', 'like', '%' . $request->search . '%')->get();

        return view('list', compact('pageCheck', 'products'));
    }
}
