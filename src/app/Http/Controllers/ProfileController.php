<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\TradingProduct;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function viewSetProfile()
    {
        $route = '/set_profile';

        return view('profile', compact('route'));
    }

    public function createProfile(ProfileRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('user_icons', $image, 'public');
        } else {
            $image = null;
        }

        $profile = [
            'user_id' => auth()->id(),
            'image' => $image,
            'name' => $request->name,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'building' => $request->building,
        ];
        Profile::create($profile);

        return redirect('/');
    }

    public function viewMypage(Request $request)
    {
        $profile = Profile::where('user_id', auth()->id());

        $rateAll = 0;
        $count = 0;
        foreach (TradingProduct::all() as $tradingProduct) {
            if ($tradingProduct->selling_user_id == auth()->id() && $tradingProduct->selling_user_rate) {
                $rateAll += $tradingProduct->selling_user_rate;
                $count += 1;
            } elseif ($tradingProduct->buying_user_id == auth()->id() && $tradingProduct->buying_user_rate) {
                $rateAll += $tradingProduct->buying_user_rate;
                $count += 1;
            }
        }
        $rateAverage = $count != 0 ? floor($rateAll / $count) : 0;

        $user = [
            'image' => $profile->value('image'),
            'name' => $profile->value('name'),
            'rate' => $rateAverage,
        ];

        if (!$request->page) {
            $pageCheck = 'sell';
        } else {
            $pageCheck = $request->page;
        }

        $sellingProductIds = Product::where('selling_user_id', auth()->id())->whereHas('tradingProduct', function ($q) {
            $q->whereNull('buying_user_rate');
        })->pluck('id');
        $purchasedProductIds = User::find(auth()->id())->purchasedProducts()->whereHas('tradingProduct', function ($q) {
            $q->whereNull('selling_user_rate');
        })->pluck('product_id');
        $allProductIds = $sellingProductIds->merge($purchasedProductIds)->unique();

        if ($pageCheck === 'sell') {
            $products = Product::where('selling_user_id', auth()->id())->get();
        } else if ($pageCheck === 'buy') {
            $products = Product::whereIn('id', User::find(auth()->id())->purchasedProducts->pluck('product_id'))->get();
        } else if ($pageCheck === 'trading') {
            $products = Product::whereIn('id', $allProductIds)->with(['purchased.tradingProduct.chat'])->get()->sortByDesc(function ($product) {
                if ($product->purchased && $product->purchased->tradingProduct) {
                    $tradingProduct = $product->purchased->tradingProduct;

                    $latestChat = $tradingProduct->chat->sortByDesc('created_at')->first();
                    return $latestChat ? $latestChat->created_at : null;
                }
                return null;
            });
        }

        $messageCount = 0;
        $messageCountDatas = [];
        foreach (Product::whereIn('id', $allProductIds)->get() as $product) {
            if (auth()->id() == $product->purchased->tradingProduct->selling_user_id) {
                $count = $product->purchased->tradingProduct->chat()->where('created_at', '>', $product->purchased->tradingProduct->selling_user_seeTime)->count();
                $messageCountDatas[$product->id] = $count;
                $messageCount += $count;
            } elseif (auth()->id() == $product->purchased->tradingProduct->buying_user_id) {
                $count = $product->purchased->tradingProduct->chat()->where('created_at', '>', $product->purchased->tradingProduct->buying_user_seeTime)->count();
                $messageCountDatas[$product->id] = $count;
                $messageCount += $count;
            }
        }

        return view('mypage', compact('user', 'pageCheck', 'products', 'messageCount', 'messageCountDatas'));
    }

    public function viewProfile()
    {
        $route = '/mypage/profile';

        $userProfile = Profile::where('user_id', auth()->id())->first();
        $profile = [
            'image' => $userProfile->image,
            'name' => $userProfile->name,
            'zip_code' => $userProfile->zip_code,
            'address' => $userProfile->address,
            'building' => $userProfile->building,
        ];

        return view('profile', compact('route', 'profile'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('user_icons', $image, 'public');
        } else {
            $image = Profile::where('user_id', auth()->id())->value('image');
        }

        $profile = [
            'user_id' => auth()->id(),
            'image' => $image,
            'name' => $request->name,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'building' => $request->building,
        ];
        Profile::where('user_id', auth()->id())->update($profile);

        return back();
    }
}
