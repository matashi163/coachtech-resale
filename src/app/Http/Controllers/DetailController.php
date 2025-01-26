<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bookmark;

class DetailController extends Controller
{
    public function viewDetail($item_id)
    {
        $product = Product::with('condision')->find($item_id);

        $bookmarkExist = Bookmark::where('user_id', auth()->id())->where('product_id', $item_id)->exists();

        $bookmarkCount = Bookmark::where('product_id', $item_id)->count();

        return view('detail', compact('product', 'bookmarkExist', 'bookmarkCount'));
    }

    public function createBookmark($item_id)
    {
        $bookmarkExist = Bookmark::where('user_id', auth()->id())->where('product_id', $item_id)->exists();
        if (!$bookmarkExist) {
            $bookmark = [
                'user_id' => auth()->id(),
                'product_id' => $item_id,
            ];
            Bookmark::create($bookmark);
        }
        
        return redirect('/item/' . $item_id);
    }

    public function deleteBookmark($item_id)
    {
        Bookmark::where('user_id', auth()->id())->where('product_id', $item_id)->delete();

        return redirect('/item/' . $item_id);
    }
}
