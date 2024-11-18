<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function loginBackend()
    {
        return view('backend.v_login', [
            'judul' => 'Login'
        ]);
    }

    public function authenticateBackend(Request $request)
    {
        // Validasi input dengan pesan error
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Coba login
        if (Auth::attempt($validator->validated())) {
            // Cek status user
            if (Auth::user()->status == 0) {
                Auth::logout();
                return back()->with('error', 'Akun anda belum aktif. Silahkan hubungi administrator.');
            }

            // Regenerate session untuk keamanan
            $request->session()->regenerate();
            
            // Redirect ke dashboard jika sukses
            return redirect()->intended(route('backend.beranda'))
                           ->with('success', 'Login berhasil!');
        }

        // Jika login gagal
        return back()
               ->with('error', 'Email atau password salah')
               ->withInput($request->only('email'));
    }

    public function logoutBackend(Request $request)
    {
        Auth::logout();
        
        // Invalidate dan regenerate session untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('backend.login')
                        ->with('success', 'Berhasil logout');
    }
}