<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ListController extends Controller
{
    public function viewList(Request $request)
    {
        $pageCheck = $request->page;

        $search = $request->search;

        if (!$pageCheck) {
            // おすすめ
            $products = Product::where('name', 'like', '%' . $search . '%')->where('selling_user_id', '!=', auth()->id())->get();
        } else {
            // マイリスト
            $products = Product::whereHas('bookmark', function ($query) {
                $query->where('user_id', auth()->id());
            })->where('name', 'like', '%' . $search . '%')->where('selling_user_id', '!=', auth()->id())->get();
        }

        return view('list', compact('pageCheck', 'search', 'products'));
    }
}
