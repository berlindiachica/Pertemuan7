<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Data tetap untuk standard user
    private $standardUser = [
        'email' => 'standard@gmail.com',
        'username' => 'standard123',
        'password' => 'Standard123',
        'type' => 'standard'
    ];

    // Data tetap untuk advance user
    private $advanceUser = [
        'email' => 'advance@gmail.com',
        'username' => 'advance123',
        'password' => 'Advance123',
        'type' => 'advance'
    ];

    public function index(){
        return view("halaman-login");
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ], [
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'password.regex' => 'Password harus mengandung huruf kecil, huruf besar, dan angka'
        ]);

        $username = $request->username;
        $email = $request->email;
        $password = $request->password;

        // Validasi terhadap data tetap
        $errors = [];
        $userType = null;

        // Cek apakah kredensial sesuai dengan standard user
        if ($username === $this->standardUser['username'] &&
            $email === $this->standardUser['email'] &&
            $password === $this->standardUser['password']) {
            $userType = 'standard';
        }
        // Cek apakah kredensial sesuai dengan advance user
        elseif ($username === $this->advanceUser['username'] &&
                $email === $this->advanceUser['email'] &&
                $password === $this->advanceUser['password']) {
            $userType = 'advance';
        }
        // Jika tidak sesuai dengan kedua fixed data
        else {
            if ($username !== $this->standardUser['username'] && $username !== $this->advanceUser['username']) {
                $errors['username'] = ['Username harus: ' . $this->standardUser['username'] . ' atau ' . $this->advanceUser['username']];
            }
            if ($email !== $this->standardUser['email'] && $email !== $this->advanceUser['email']) {
                $errors['email'] = ['Email harus: ' . $this->standardUser['email'] . ' atau ' . $this->advanceUser['email']];
            }
            if ($password !== $this->standardUser['password'] && $password !== $this->advanceUser['password']) {
                $errors['password'] = ['Password harus: ' . $this->standardUser['password'] . ' atau ' . $this->advanceUser['password']];
            }
        }

        // Jika ada error validasi custom
        if (!empty($errors)) {
            return redirect()->route('login.index')
                ->withErrors($errors)
                ->withInput();
        }

        // Login berhasil - redirect berdasarkan tipe user
        session([
            'logged_in' => true,
            'username' => $username,
            'user_type' => $userType
        ]);

        if ($userType === 'standard') {
            return redirect()->route('home.standard')->with('success', 'Login Berhasil! Selamat datang Standard User ' . $username);
        } else {
            return redirect()->route('home.advance')->with('success', 'Login Berhasil! Selamat datang Advance User ' . $username);
        }
    }
}
