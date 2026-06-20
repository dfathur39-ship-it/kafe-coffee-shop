<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.admin-login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (! Auth::user()->isAdmin()) {
                Auth::logout();

                return back()->withErrors(['email' => 'Akun ini bukan admin. Gunakan login Pelanggan.']);
            }

            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }
}
