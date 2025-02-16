<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Profile;
use App\Models\PurchasedProduct;
use App\Http\Requests\AdressRequest;

class PurchaseController extends Controller
{
    public function viewPurchase($item_id)
    {
        $profile = Profile::find(auth()->id());

        $product = Product::find($item_id);

        $zipCode = $profile->zip_code;

        $adress = $profile->adress;

        $building = $profile->building;

        return view('purchase', compact('product', 'zipCode', 'adress', 'building'));
    }

    public function viewChangeAdress($item_id)
    {        
        return view('change_adress', compact('item_id'));
    }

    public function changeAdress(AdressRequest $request)
    {
        $product = Product::find($request->item_id);

        $zipCode = $request->zip_code;

        $adress = $request->adress;

        $building = $request->building;
        
        return view('purchase', compact('product', 'zipCode', 'adress', 'building'));
    }

    public function purchase(Request $request)
    {
        PurchasedProduct::create([
            'product_id' => $request->product_id,
            'buying_user_id' => $request->user_id,
            'zip_code' => $request->zip_code,
            'adress' => $request->adress,
            'building' => $request->building,
        ]);
        
        return redirect('/');
    }
}
