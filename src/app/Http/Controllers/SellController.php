<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Condision;
use App\Models\Product;
use App\Models\ProductCategory;

class SellController extends Controller
{
    public function viewSell()
    {
        $categories = Category::all();

        $condisions = Condision::all();
        
        return view('sell', compact('categories', 'condisions'));
    }

    public function sell(Request $request)
    {
        $image = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('product_images', $image, 'public');

        $product = Product::create([
            'name' => $request->name,
            'image' => $image,
            'brand' => $request->brand,
            'price' => $request->price,
            'description' => $request->description,
            'condision_id' => $request->condision,
            'selling_user_id' => auth()->id(),
        ]);

        foreach ($request->category as $category) {
            ProductCategory::create([
                'product_id' => $product->id,
                'category_id' => $category,
            ]);
        }
        return redirect('/');
    }
}
