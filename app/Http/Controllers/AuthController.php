<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->only(['username', 'password']);

        $validate = Validator::make($data, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'msg' => $validate->errors(),
            ]);
        }

        $users = User::where('username', $data['username'])->first();
        if ($users) {
            if (Hash::check($data['password'], $users->password)) {

                $barearToken = $users->createToken($data['username'])->plainTextToken;

                $request->session()->regenerate();
                $request->session()->put('token', $barearToken);
                $request->session()->put('user', $users);
                $request->session()->put('business_id', $users->business_id);

                return response()->json([
                    'success' => true,
                    'msg' => 'Login Berhasil.',
                    'token' => $barearToken,
                    'user' => $users
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'msg' => 'Username atau Password salah.'
        ]);
    }
}
