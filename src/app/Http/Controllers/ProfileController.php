<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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
            'adress' => $request->adress,
            'building' => $request->building,
        ];
        Profile::create($profile);
        
        return redirect('/');
    }
    
    public function viewMypage(Request $request)
    {
        $profile = Profile::where('user_id', auth()->id());
        $user = [
            'image' => $profile->value('image'),
            'name' => $profile->value('name'),
        ];

        if (!$request->page) {
            $pageCheck = 'listed';
        } else {
            $pageCheck = $request->page;
        }

        if ($pageCheck === 'listed') {
            // 出品した商品
            $products = Product::where('selling_user_id', auth()->id())->get();
        } else if ($pageCheck === 'purchased') {
            $products = Product::where('buying_user_id', auth()->id())->get();
        }
        
        return view('mypage', compact('user', 'pageCheck', 'products'));
    }

    public function viewProfile()
    {
        $route = '/mypage/profile';

        $userProfile = Profile::where('user_id', auth()->id())->first();
        $profile = [
            'image' => $userProfile->image,
            'name' => $userProfile->name,
            'zip_code' => $userProfile->zip_code,
            'adress' => $userProfile->adress,
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
            'adress' => $request->adress,
            'building' => $request->building,
        ];
        Profile::where('user_id', auth()->id())->update($profile);
        
        return back();
    }
}
