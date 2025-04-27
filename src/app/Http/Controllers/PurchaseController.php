<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Profile;
use App\Models\PurchasedProduct;
use App\Models\TradingProduct;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
    public function viewPurchase($item_id)
    {
        $profile = Profile::where('user_id', auth()->id())->first();

        $product = Product::find($item_id);

        $zipCode = $profile->zip_code;

        $address = $profile->address;

        $building = $profile->building;

        return view('purchase', compact('product', 'zipCode', 'address', 'building'));
    }

    public function viewChangeAddress(Request $request, $item_id)
    {
        $zipCode = $request->zip_code;

        $address = $request->address;

        $building = $request->building;

        return view('change_address', compact('zipCode', 'address', 'building', 'item_id'));
    }

    public function changeaddress(AddressRequest $request)
    {
        $product = Product::find($request->item_id);

        $zipCode = $request->zip_code;

        $address = $request->address;

        $building = $request->building;

        return view('purchase', compact('product', 'zipCode', 'address', 'building'));
    }

    public function purchase(Request $request)
    {
        $purchasedProduct = PurchasedProduct::create([
            'product_id' => $request->product_id,
            'buying_user_id' => $request->user_id,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        TradingProduct::create([
            'purchased_product_id' => $purchasedProduct->id,
            'selling_user_id' => $purchasedProduct->product->selling_user_id,
            'buying_user_id' => $purchasedProduct->buying_user_id,
            'selling_user_seeTime' => Carbon::now(),
            'buying_user_seeTime' => Carbon::now(),
            'completion' => false,
        ]);

        return redirect('/');
    }
}
