<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\AdressRequest;

class PurchaseController extends Controller
{
    public function viewPurchase($item_id)
    {
        $product = Product::find($item_id);

        return view('purchase', compact('product'));
    }

    public function viewChangeAdress($item_id)
    {        
        return view('change_adress', compact('item_id'));
    }

    public function changeAdress(AdressRequest $request)
    {
        $product = Product::find($request->item_id);

        $zipCode = preg_replace('/^(\d{3})(\d{4})$/', '$1-$2', $request->zip_code);

        $adress = $request->adress . ' ' . $request->building;
        
        return view('purchase', compact('product', 'zipCode', 'adress'));
    }

    public function purchase(Request $request)
    {
        Product::find($request->product_id)->update(['buying_user_id' => $request->user_id]);
        
        return redirect('/');
    }
}
