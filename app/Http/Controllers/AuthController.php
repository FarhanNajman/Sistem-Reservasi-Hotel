<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        // Jika sudah login, redirect ke halaman utama
        if (Auth::check()) {
            return redirect('/reservasi_hotel');
        }

        return view('auth.login');
    }

    /**
     * Proses login user.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'login_type' => ['nullable', 'in:user,admin'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'login_type.in' => 'Tipe login tidak valid.',
        ]);

        $validated['login_type'] = $validated['login_type'] ?? 'user';

        $remember = $request->boolean('remember');
        $user = User::where('username', $validated['username'])->first();

        if ($user && $user->role !== $validated['login_type']) {
            throw ValidationException::withMessages([
                'username' => ['Akun ini tidak terdaftar sebagai ' . ($validated['login_type'] === 'admin' ? 'admin' : 'user') . '.'],
            ]);
        }

        if (Auth::attempt([
            'username' => $validated['username'],
            'password' => $validated['password'],
        ], $remember)) {
            $request->session()->regenerate();

            $redirectUrl = Auth::user()->role === 'admin'
                ? route('admin.dashboard')
                : '/reservasi_hotel';

            return redirect()->intended($redirectUrl)
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->username . '!');
        }

        throw ValidationException::withMessages([
            'username' => ['Username atau password yang Anda masukkan salah.'],
        ]);
    }

    /**
     * Tampilkan halaman registrasi.
     */
    public function showRegister()
    {
        // Jika sudah login, redirect ke halaman utama
        if (Auth::check()) {
            return redirect('/reservasi_hotel');
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi user baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'min:4', 'max:50', 'unique:users,username', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan garis bawah.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->username, // Default name to username
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/reservasi_hotel')
            ->with('success', 'Akun Anda berhasil didaftarkan dan Anda telah masuk!');
    }

    /**
     * Proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/reservasi_hotel')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
