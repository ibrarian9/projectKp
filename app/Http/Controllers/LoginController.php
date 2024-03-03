<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function login(): View
    {
        return view('Login');
    }

    public function loginDashboard(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username is required',
            'password.required' => 'Password is required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('akun = '.Auth::user());
            try {
                return redirect()->route('dashboard');
            } catch (\Exception $e){
                Log::error('Error = '.$e->getMessage());
                return back();
            }
        }
        return back()->withErrors('Data yang dimasukkan tidak sesuai')->withInput();

    }

    public function logout(Request $req): RedirectResponse
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/');
    }
}
