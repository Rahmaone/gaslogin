<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('isGuest');
    }

    public function indexuser()
    {
        return view('frontend.login');
    }

    public function loginproses(Request $request)
    {
        $request->validate([
            'email'     => 'required',
            'password'  => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        } else {
            return redirect()->route('loginUser')->with('failed', 'Email atau Password Salah');
        }
    }

    public function registeruser(Request $request)
    {
        return view('frontend.register');

    }

    public function forgotpassworduser()
    {
        return view('frontend.forgot_password');
    }

    public function registerprosesuser(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isActive' => false,
        ]);

        $user->assignRole('pengguna_biasa');

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        } else {
            return redirect()->route('loginUser')->with('failed', 'Email atau Password Salah');
        }
    }

    public function forgotpassworduseract(Request $request)
    {
        $customMessage = [
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Email tidak valid',
            'email.exists'      => 'Email tidak terdaftar di database',
        ];

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], $customMessage);

        $token = Str::random(60);

        PasswordResetToken::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return redirect()->route('forgotpassworduser')->with('success','Kami telah mengirimkan link reset password ke email anda');
    }

    public function validasiforgotpassworduser(Request $request, $token)
    {
        $getToken = PasswordResetToken::where('token', $token)->first();

        if (!$getToken) {
            return redirect()->route('loginUser')->with('failed', 'Token tidak valid');
        }

        return view('frontend.validasitokenuser', compact('token'));
    }

    public function validasiforgotpasswordactusers(Request $request)
    {
        $customMessage = [
            'password.required' => 'Password tidak boleh kosong',
            'password.min'      => 'Password minimal 6 karakter',
        ];

        $request->validate([
            'password' => 'required|min:6'
        ], $customMessage);

        $token = PasswordResetToken::where('token', $request->token)->first();

        if (!$token) {
            return redirect()->route('loginUser')->with('failed', 'Token tidak valid');
        }

        $user = User::where('email', $token->email)->first();

        if (!$user) {
            return redirect()->route('loginUser')->with('failed', 'Email tidak terdaftar di database');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $token->delete();


        return redirect()->route('loginUser')->with('success','Password berhasil direset');
    }
    


}
