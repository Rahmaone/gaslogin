<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RedirectGuestToLoginUser;

class UserController extends Controller
{

    public function createtour()
    {   
        if (Auth::check()) {
            return view('frontend.createtour');
        } else {
            return view('frontend.login');
        }
    }

    public function logoutuser()
    {
        Auth::logout();
        return redirect()->route('loginUser')->with('success', 'Kamu berhasil logout');
    }



}
