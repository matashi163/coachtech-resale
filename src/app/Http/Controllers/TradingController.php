<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationMailable;
use App\Models\User;
use App\Models\Product;
use App\Models\Chat;
use App\Http\Requests\ChatRequest;
use App\Http\Requests\ChatCorrectRequest;

class TradingController extends Controller
{
    public function viewTrading($item_id)
    {
        $user = User::find(auth()->id());
        $product = Product::find($item_id);
        $tradingProduct = $product->purchased->tradingProduct;

        $sellingProductIds = Product::where('selling_user_id', auth()->id())->whereHas('tradingProduct', function ($q) {
            $q->where('completion', false);
        })->pluck('id');
        $purchasedProductIds = User::find(auth()->id())->purchasedProducts()->whereHas('tradingProduct', function ($q) {
            $q->where('completion', false);
        })->pluck('product_id');
        $allProductIds = $sellingProductIds->merge($purchasedProductIds)->unique();
        $products = Product::whereIn('id', $allProductIds)->with(['purchased.tradingProduct.chat'])->get()->sortByDesc(function ($product) {
            if ($product->purchased && $product->purchased->tradingProduct) {
                $tradingProduct = $product->purchased->tradingProduct;

                $latestChat = $tradingProduct->chat->sortByDesc('created_at')->first();
                return $latestChat ? $latestChat->created_at : null;
            }
            return null;
        });

        $sellingUser = $product->sellingUser;
        $buyingUser = $product->purchased->buyingUser;

        if ($user == $sellingUser) {
            $oneself = $sellingUser;
            $partner = $buyingUser;
            $position = 'selling_user';

            $tradingProduct->update([
                'selling_user_seeTime' => Carbon::now(),
            ]);
        } elseif ($user == $buyingUser) {
            $oneself = $buyingUser;
            $partner = $sellingUser;
            $position = 'buying_user';

            $tradingProduct->update([
                'buying_user_seeTime' => Carbon::now(),
            ]);
        }

        $productData = [
            'oneself_id' => $oneself->id,
            'oneself_icon' => $oneself->profile->image,
            'oneself_name' => $oneself->name,
            'partner_id' => $partner->id,
            'partner_icon' => $partner->profile->image,
            'partner_name' => $partner->name,
            'product_id' => $product->id,
            'product_image' => $product->image,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'position' => $position,
            'completion' => $tradingProduct->completion,
        ];

        $chats = $tradingProduct->chat()->orderBy('created_at', 'asc')->get();

        return view('trading', compact('products', 'productData', 'chats'));
    }

    public function chat(ChatRequest $request, $item_id)
    {
        $user = User::find(auth()->id());
        $product = Product::find($item_id);
        $image = null;

        if ($request->file('image')) {
            $image = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('chat_images', $image, 'public');
        }

        Chat::create([
            'trading_product_id' => $product->purchased->tradingProduct->id,
            'user_id' => $user->id,
            'text' => $request->text,
            'image' => $image,
        ]);

        return back();
    }

    public function correct(ChatCorrectRequest $request, $chat_id)
    {
        Chat::find($chat_id)->update([
            'text' => $request->text,
        ]);

        return back();
    }

    public function delete($chat_id)
    {
        Chat::find($chat_id)->delete();

        return back();
    }

    public function completion($item_id)
    {
        $product = Product::find($item_id);
        $product->purchased->tradingProduct->update([
            'completion' => true,
        ]);

        Mail::to(User::find(auth()->id())->email)->send(new ConfirmationMailable());

        return back();
    }

    public function rate(Request $request, $item_id)
    {
        $tradingProduct = Product::find($item_id)->purchased->tradingProduct;

        if (auth()->id() == $tradingProduct->selling_user_id) {
            $tradingProduct->update([
                'buying_user_rate' => $request->rate,
            ]);
        } elseif (auth()->id() == $tradingProduct->buying_user_id) {
            $tradingProduct->update([
                'selling_user_rate' => $request->rate,
            ]);
        }

        return redirect('/mypage');
    }
}
