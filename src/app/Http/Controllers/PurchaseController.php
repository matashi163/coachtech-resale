<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Profile;
use App\Models\PurchasedProduct;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
    public function viewPurchase($item_id)
    {
        $profile = Profile::find(auth()->id());

        $product = Product::find($item_id);

        $zipCode = $profile->zip_code;

        $address = $profile->address;

        $building = $profile->building;

        return view('purchase', compact('product', 'zipCode', 'address', 'building'));
    }

    public function viewChangeaddress($item_id)
    {        
        return view('change_address', compact('item_id'));
    }

    public function changeaddress(addressRequest $request)
    {
        $product = Product::find($request->item_id);

        $zipCode = $request->zip_code;

        $address = $request->address;

        $building = $request->building;
        
        return view('purchase', compact('product', 'zipCode', 'address', 'building'));
    }

    public function purchase(Request $request)
    {
        PurchasedProduct::create([
            'product_id' => $request->product_id,
            'buying_user_id' => $request->user_id,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        
        return redirect('/');
    }
}
