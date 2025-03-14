<?php

namespace App\Http\Controllers;

use App\Imports\FileImport;
use App\Models\Account;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Installations;
use App\Models\User;
use App\Models\Settings;
use App\Models\Usage;
use App\Models\Menu;
use App\Models\Package;
use App\Models\Tombol;
use App\Models\Village;
use App\Utils\Migrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Excel;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function index()
    {
        $url = request()->getHost();
        $business = Business::where('domain', 'LIKE', '%' . $url . '%')->first();
        $domain = json_decode($business->domain, true);
        if ($domain[0] != $url && $url != 'siap_mapan.test') {
            return redirect('https://' . $domain[0]);
        }

        return view('auth.login')->with(compact('business'));
    }

    public function register()
    {
        return view('auth.register');
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

    public function proses_register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'file|mimes:xls,xlsx',
        ]);

        $data = $request->except('file', '_token');
        $file = $request->file('file');

        $business = Business::where('nama', $data['name'])->first();
        if (!$business) {
            $businessBaru = Business::create([
                'nama' => $data['name'],
                'telpon' => $data['telpon'],
                'email' => $data['email'],
                'alamat' => $data['alamat']
            ]);

            $setting = Settings::orderBy('id')->first()->toArray();
            $setting['business_id'] = $businessBaru->id;

            unset($setting['id']);
            unset($setting['created_at']);
            unset($setting['updated_at']);

            $settingBusiness = Settings::create($setting);
        } else {
            $businessBaru = $business;
            $settingBusiness = Settings::where('business_id', $businessBaru->id)->first();
        }

        $file->storeAs('migrasi', $file->getClientOriginalName());
        $filename = 'migrasi/' . $file->getClientOriginalName();

        return $this->migrasi_file($businessBaru, $filename);
    }

    public function migrasi_file($business, $file)
    {
        $excel = (new FileImport())->toArray($file);

        $migrasiDesa = $excel['DESA'];
        $migrasiPaket = $excel['PAKET'];
        $migrasiInstalasi = $excel['INSTALASI'];

        Session::put('business_id', $business->id);
        Session::put('migrasi_desa', $migrasiDesa);
        Session::put('migrasi_paket', $migrasiPaket);
        Session::put('migrasi_instalasi', $migrasiInstalasi);

        return view('auth.migrasi.proses');
    }

    public function migrasi_desa()
    {
        $migrasiDesa = Session::get('migrasi_desa');
        if ($migrasiDesa) {
            $header = 1;
            $data_kode = [];
            $data_desa = [];
            $business_id = Session::get('business_id');
            foreach ($migrasiDesa as $desa) {
                if ($header == 1 || !$desa[1]) {
                    $header = 0;
                    continue;
                }

                $kode_desa = str_pad($desa[0], 4, '0', STR_PAD_LEFT);
                $business_id = str_pad($business_id, 3, '0', STR_PAD_LEFT);

                $kd_desa =  $business_id . '.' . $kode_desa;
                $data_desa[$desa[1]] = [
                    'kode' => $kd_desa,
                    'nama' => ucwords(strtolower($desa[1])),
                    'alamat' => '-',
                    'hp' => '08'
                ];

                $data_kode[] = $kd_desa;
            }

            Village::whereIn('kode', $data_kode)->delete();
            Village::insert($data_desa);

            Session::put('data_desa', $data_desa);
            return response()->json([
                'success' => true,
                'time' => date('Y-m-d H:i:s'),
                'msg' => 'Migrasi data desa selesai',
                'next' => '/migrasi/paket',
                'finish' => false
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function migrasi_paket()
    {
        $migrasiPaket = Session::get('migrasi_paket');
        if ($migrasiPaket) {
            $header = 1;
            $data_paket = [];
            foreach ($migrasiPaket as $paket) {
                if ($header == 1) {
                    $header = 0;
                    continue;
                }

                $harga = [];
                for ($i = 2; $i < count($paket); $i++) {
                    $harga[] = $paket[$i] ?: 0;
                }
                $harga = json_encode($harga);

                $data_paket[strtolower(substr($paket[1], 0, 1))] = [
                    'business_id' => Session::get('business_id'),
                    'kelas' => $paket[1],
                    'harga' => $harga
                ];
            }

            Package::where('business_id', Session::get('business_id'))->delete();
            Package::insert($data_paket);

            Session::put('data_paket', $data_paket);
            return response()->json([
                'success' => true,
                'time' => date('Y-m-d H:i:s'),
                'msg' => 'Migrasi data paket selesai',
                'next' => '/migrasi/customer',
                'finish' => false
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function migrasi_customer()
    {
        $migrasiCustomer = Session::get('migrasi_instalasi');
        if ($migrasiCustomer) {
            $desa = Village::where('kode', 'LIKE', Session::get('business_id' . '%'))->get();

            $header = 1;
            $data_cater = [];
            $data_customer = [];
            $data_desa = Session::get('data_desa');
            foreach ($migrasiCustomer as $customer) {
                if ($header == 1) {
                    $header = 0;
                    continue;
                }

                $id_desa = 0;
                $kode_desa = $data_desa[$customer[2]]['kode'];
                foreach ($desa as $d) {
                    if ($d->kode == $kode_desa) {
                        $id_desa = $d->id;
                        break;
                    }
                }

                $data_customer[$customer[0]] = [
                    'business_id' => Session::get('business_id'),
                    'nama' => ucwords(strtolower($customer[3])),
                    'desa' => $id_desa,
                    'status' => $customer[0]
                ];

                $cater = strtolower($customer[4]);
                if (!array_key_exists($cater, $data_cater)) {
                    $username = $cater . Session::get('business_id');
                    $password = Hash::make($username);

                    $data_cater[$cater] = [
                        'business_id' => Session::get('business_id'),
                        'nama' => $cater,
                        'jabatan' => '5',
                        'username' => $username,
                        'password' => $password,
                        'auth_token' => $cater
                    ];
                }
            }

            Customer::where('business_id', Session::get('business_id'))->delete();
            Customer::insert($data_customer);

            User::where([
                ['business_id', Session::get('business_id')],
                ['jabatan', '5']
            ])->delete();
            User::insert($data_cater);

            Session::put('data_customer', $data_customer);
            Session::put('data_cater', $data_cater);
            return response()->json([
                'success' => true,
                'time' => date('Y-m-d H:i:s'),
                'msg' => 'Migrasi data customer selesai',
                'next' => '/migrasi/instalasi',
                'finish' => false
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function migrasi_instalasi()
    {
        $migrasiInstalasi = Session::get('migrasi_instalasi');
        if ($migrasiInstalasi) {
            $desa = Village::where('kode', 'LIKE', Session::get('business_id' . '%'))->get();

            $customer = Customer::where('business_id', Session::get('business_id'))->get();
            $data_customer = [];
            foreach ($customer as $cs) {
                $data_customer[$cs->status] = $cs->id;
            }

            $cater = User::where([
                ['business_id', Session::get('business_id')],
                ['jabatan', '5']
            ])->get();
            $data_cater = [];
            foreach ($cater as $c) {
                $data_cater[$c->auth_token] = $c->id;
            }

            $paket = Package::where('business_id', Session::get('business_id'))->get();
            $data_paket = [];
            foreach ($paket as $p) {
                $data_paket[$p->kelas] = $p->id;
            }

            $header = 1;
            $data_instalasi = [];
            $data_desa = Session::get('data_desa');
            foreach ($migrasiInstalasi as $instalasi) {
                if ($header == 1) {
                    $header = 0;
                    continue;
                }

                $id_desa = 0;
                $kode_desa = $data_desa[$instalasi[2]]['kode'];
                foreach ($desa as $d) {
                    if ($d->kode == $kode_desa) {
                        $id_desa = $d->id;
                        break;
                    }
                }

                $cater = strtolower($instalasi[4]);
                $cater_id = $data_cater[$cater];
                $customer_id = $data_customer[$instalasi[0]];

                $kode = explode('.', $instalasi[0]);
                $kode_instalasi = $id_desa . '.' . str_pad($cater_id, 2, '0', STR_PAD_LEFT) . '.' . $kode[2];

                $paket = Session::get('data_paket')[strtolower(end($kode))]['kelas'];
                $paket_id = $data_paket[$paket];

                $data_instalasi[$instalasi[0]] = [
                    'kode_instalasi' => $kode_instalasi,
                    'customer_id' => $customer_id,
                    'business_id' => Session::get('business_id'),
                    'cater_id' => $cater_id,
                    'package_id' => $paket_id,
                    'desa' => $id_desa,
                    'alamat' => $instalasi[5],
                    'abodemen' => $instalasi[6],
                    'biaya_instalasi' => $instalasi[8],
                    'order' => Date::excelToDateTimeObject($instalasi[1])->format('Y-m-d'),
                    'pasang' => Date::excelToDateTimeObject($instalasi[1])->format('Y-m-d'),
                    'aktif' => Date::excelToDateTimeObject($instalasi[1])->format('Y-m-d'),
                    'status' => 'A'
                ];
            }

            Installations::where('business_id', Session::get('business_id'))->delete();
            Installations::insert($data_instalasi);

            Session::put('data_instalasi', $data_instalasi);
            return response()->json([
                'success' => true,
                'time' => date('Y-m-d H:i:s'),
                'msg' => 'Migrasi data instalasi selesai',
                'next' => '/migrasi/pemakaian',
                'finish' => false
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function migrasi_pemakaian()
    {
        $migrasiPemakaian = Session::get('migrasi_instalasi');
        if ($migrasiPemakaian) {
            $instalasi = Installations::where('business_id', Session::get('business_id'))->get();
            $data_instalasi = [];
            foreach ($instalasi as $ins) {
                $data_instalasi[$ins->kode_instalasi] = $ins->id;
            }

            $header = 1;
            $data_pemakaian = [];
            foreach ($migrasiPemakaian as $pemakaian) {
                if ($header == 1) {
                    $header = 0;
                    continue;
                }

                $instalasi = Session::get('data_instalasi')[$pemakaian[0]];
                $id_instalasi = $data_instalasi[$instalasi['kode_instalasi']];
                $business_id = Session::get('business_id');
                $customer_id = $instalasi['customer_id'];
                $cater_id = $instalasi['cater_id'];

                $data_pemakaian[] = [
                    'business_id' => $business_id,
                    'id_instalasi' => $id_instalasi,
                    'customer' => $customer_id,
                    'awal' => 0,
                    'akhir' => $pemakaian[10],
                    'jumlah' => $pemakaian[10],
                    'nominal' => 0,
                    'tgl_akhir' => Date::excelToDateTimeObject($ins[9])->format('Y-m-d'),
                    'cater' => $cater_id,
                    'status' => 'UNPAID'
                ];
            }

            Usage::where('business_id', Session::get('business_id'))->delete();
            Usage::insert($data_pemakaian);

            Session::put('data_pemakaian', $data_pemakaian);
            return response()->json([
                'success' => true,
                'time' => date('Y-m-d H:i:s'),
                'msg' => 'Migrasi data pemakaian selesai',
                'next' => '/migrasi/sync',
                'finish' => false
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function migrasi_sync()
    {
        $rekening = Account::where('business_id', '1')->get();
        $data_rekening = [];
        foreach ($rekening as $rek) {
            $data_rekening[] = [
                'parent_id' => $rek->parent_id,
                'business_id' => Session::get('business_id'),
                'lev1' => $rek->lev1,
                'lev2' => $rek->lev2,
                'lev3' => $rek->lev3,
                'lev4' => $rek->lev4,
                'kode_akun' => $rek->kode_akun,
                'nama_akun' => $rek->nama_akun,
                'jenis_mutasi' => $rek->jenis_mutasi,
            ];
        }

        Account::where('business_id', Session::get('business_id'))->delete();
        Account::insert($data_rekening);

        User::insert([
            'nama' => 'Direktur',
            'jabatan' => '1',
            'username' => 'direktur' . Session::get('business_id'),
            'password' => Hash::make('direktur' . Session::get('business_id')),
            'business_id' => Session::get('business_id')
        ]);

        return response()->json([
            'success' => true,
            'time' => date('Y-m-d h:i:s'),
            'msg' => 'Migrasi Selesai',
            'finish' => true
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/auth')->with('success', 'Logout Berhasil');
    }
}
