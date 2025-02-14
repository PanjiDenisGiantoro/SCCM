<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

                activity()
                    ->causedBy(Auth::user())
                    ->log('Login');
                return response()->json([
                    'success' => true,
                    'message' => 'Login Berhasil',
                    'data' => Auth::user()
                ]);
            }else{
                activity()
                    ->causedBy(Auth::user())
                    ->log('Login Gagal');
                return response()->json([
                    'success' => false,
                    'message' => 'Login Gagal'
                ]);
            }

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }
}
