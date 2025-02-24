<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.signIn');
    }
    public function process(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                activity()
                    ->causedBy(Auth::user())
                    ->log('Login');

                return redirect()->route('home');

            }else{
                activity()
                    ->causedBy(Auth::user())
                    ->log('Login Gagal');
                Alert::error('Error', 'Login Gagal');
                return redirect()->route('login');
            }

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }
}
