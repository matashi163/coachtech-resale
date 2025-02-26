<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            $user = User::find(auth()->id());
            
            if ($user->first_login) {
                $user->update(['first_login' => false]);

                return redirect('/set_profile');
            } else {
                return redirect('/');
            }
        } else {
            return view('auth.login');
        }
    }
}
