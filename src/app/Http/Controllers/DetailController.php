<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class DetailController extends Controller
{
    public function viewDetail($item_id)
    {
        $product = Product::with('condision')->find($item_id);

        $bookmarked = Bookmark::where('user_id', auth()->id())->where('product_id', $item_id)->exists();

        $bookmarkCount = Bookmark::where('product_id', $item_id)->count();

        $comment = Comment::where('product_id', $item_id);
        
        $commentCount = $comment->count();

        $comments = $comment->get();

        return view('detail', compact('product', 'bookmarked', 'bookmarkCount', 'commentCount', 'comments'));
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
        
        return back();
    }

    public function deleteBookmark($item_id)
    {
        Bookmark::where('user_id', auth()->id())->where('product_id', $item_id)->delete();

        return back();
    }

    public function comment(CommentRequest $request)
    {
        $comment = [
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'comment' => $request->comment,
        ];
        Comment::create($comment);
        
        return back();
    }
}
