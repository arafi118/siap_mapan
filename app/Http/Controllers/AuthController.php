<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->only(['username', 'password']);

        $validate = Validator::make($data, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Username dan Password harus diisi');
        }

        if (Auth::attempt($data)) {
            $user = User::where('username', $data['username'])->first();
            $business = Business::where('id', $user->business_id)->first();

            $auth_token = md5(strtolower($data['username'] . '|' . $data['password']));
            User::where('id', $user->id)->update([
                'auth_token' => $auth_token,
            ]);

            $request->session()->regenerate();
            session([
                'nama_usaha' => $business->nama,
                'nama' => $user->nama,
                'logo' => $business->logo,
                'business_id' => $business->id,
                'is_auth' => true,
                'auth_token' => $auth_token,
            ]);

            return redirect('/')->with('success', 'Login Berhasil');
        }

        return redirect()->back()->with('error', 'Login Gagal. Username atau Password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/auth')->with('success', 'Logout Berhasil');
    }
}
