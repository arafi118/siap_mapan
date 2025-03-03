<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Installations;
use App\Models\User;
use App\Models\Settings;
use App\Models\Usage;
use App\Models\Menu;
use App\Models\Tombol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

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
            $pengaturan = Settings::where('business_id', $business->id)->first();
            $installations = Installations::where('business_id', $business->id)->where('status', 'A')->get();
            $usages = Usage::whereIn('id_instalasi', $installations->pluck('id'))->where('status', 'LIKE', 'UNPAID')->get()->groupBy('id_instalasi');

            // mengecek apakah ada data aktif yang melebihi tagihan
            $batas = intval($pengaturan->batas_tagihan);
            foreach ($usages as $id_instalasi => $usageList) {
                foreach ($usageList as $usage) {
                    $bulanTglAkhir = intval(date('m', strtotime($usage->tgl_akhir)));
                    if ($bulanTglAkhir > $batas) {
                        Installations::where('id', $id_instalasi)->update([
                            'status' => 'B',
                            'blokir' => now()->format('Y-m-d')
                        ]);
                    }
                }
            }
            //proses login
            $auth_token = md5(strtolower($data['username'] . '|' . $data['password']));
            User::where('id', $user->id)->update([
                'auth_token' => $auth_token,
            ]);

            $menu = Menu::where('parent_id', '0')->whereNotIn('id', json_decode($user->akses_menu, true))->with([
                'child' => function ($query) use ($user) {
                    $query->whereNotIn('id', json_decode($user->akses_menu, true));
                }
            ])->get();

            $request->session()->regenerate();
            session([
                'nama_usaha' => $business->nama,
                'nama' => $user->nama,
                'jabatan' => $user->jabatan,
                'logo' => $business->logo,
                'business_id' => $business->id,
                'is_auth' => true,
                'auth_token' => $auth_token,
                'menu' => $menu
            ]);

            return redirect('/')->with('success', 'Selamat ' . $user->nama . ', berhasil login!');
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
