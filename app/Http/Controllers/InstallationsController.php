<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Family;
use App\Models\Installations;
use App\Models\Package;
use App\Models\Region;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\Usage;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;
use App\Utils\Keuangan;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class InstallationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $installations = Installations::all();
        $status_P = Installations::whereIn('status', ['P', '0'])->with(
            'customer',
            'village',
            'package'
        )->get();
        $status_S = Installations::where('status', 'S')->with(
            'customer',
            'package'
        )->get();
        $status_A = Installations::where('status', 'A')->with(
            'customer',
            'package'
        )->get();
        $status_B = Installations::where('status', 'B')->with(
            'customer',
            'package'
        )->get();
        $status_C = Installations::where('status', 'C')->with(
            'customer',
            'package'
        )->get();

        $title = 'Proposal';
        return view('perguliran.index')->with(compact('title', 'installations', 'status_P', 'status_S', 'status_A', 'status_B', 'status_C'));
    }

    public function cariCustomers(Request $request)
    {
        $query = $request->input('query');

        $customers = Customer::where(function ($q) use ($query) {
            $q->where('nama', 'LIKE', "%{$query}%")
                ->orWhere('nik', 'LIKE', "%{$query}%");
        })->with([
            'installation' => function ($query) {
                $query->where('status', '0');
            },
            'installation.transaction' => function ($query) {
                $query->where([
                    ['rekening_debit', '1'],
                    ['rekening_kredit', '67']
                ]);
            },
            'village',
            'installation.package'
        ])->get();

        return response()->json($customers);
    }

    public function kode_instalasi()
    {
        $kd_desa = request()->get('kode');
        $jumlah_kode_instalasi_by_desa = Installations::where('desa', $kd_desa)->orderBy('kode_instalasi', 'DESC');

        $desa = Village::where('id', $kd_desa)->first();
        $kd_prov = substr($desa->kode, 0, 2);
        $kd_kab = substr($desa->kode, 2, 2);
        $kd_kec = substr($desa->kode, 4, 2);
        $kd_desa = substr($desa->kode, 6, 4);
        $kode_instalasi = $kd_prov . '.' . $kd_kab . '.' . $kd_kec . '.' . $kd_desa;

        if ($jumlah_kode_instalasi_by_desa->count() > 0) {
            $jumlah = str_pad(($jumlah_kode_instalasi_by_desa->count() + 1), 3, "0", STR_PAD_LEFT);
        } else {
            $jumlah = str_pad(Installations::where('desa', $kd_desa)->count() + 1, 3, "0", STR_PAD_LEFT);
        }

        $kode_instalasi .= '.' . $jumlah;

        if (request()->get('kd_instalasi')) {
            $kd_ins = request()->get('kd_instalasi');
            $instalasi = Installations::where('kd_instalasi', $kd_ins);
            if ($instalasi->count() > 0) {
                $data_ins = $instalasi->first();

                if ($kd_desa == $data_ins->desa) {
                    $kode_instalasi = $data_ins->kd_instalasi;
                }
            }
        }

        return response()->json([
            'kd_instalasi' => $kode_instalasi
        ], Response::HTTP_ACCEPTED);
    }

    public function jenis_paket($id)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $package = Package::where('id', $id)->first();


        $tampil_settings = $pengaturan->first();
        return response()->json([
            'success' => true,
            'view' => view('perguliran.partials.jenis_paket')->with(compact('tampil_settings', 'package'))->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function create()
    {
        $paket = Package::all();
        $installations = Installations::all();
        $settings = Settings::first();
        $customer = Customer::with('Village')->orderBy('id', 'ASC')->get();
        $desa = Village::all();

        $pilih_desa = 0;
        $title = 'Register Proposal';
        return view('perguliran.create')->with(compact('settings', 'paket', 'installations', 'customer', 'desa', 'pilih_desa', 'title'));
    }

    public function store(Request $request)
    {
        $data = $request->only([
            "customer_id",
            "order",
            "desa",
            "alamat",
            "koordinate",
            "package_id",
            "abodemen",
            "kode_instalasi",
            "total",
        ]);

        $rules = [
            'kode_instalasi' => 'required',
            'customer_id' => 'required',
            'order' => 'required',
            'desa' => 'required',
            'alamat' => 'required',
            'koordinate' => 'required',
            'package_id' => 'required'
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $data['abodemen'] = str_replace(',', '', $data['abodemen']);
        $data['abodemen'] = str_replace('.00', '', $data['abodemen']);
        $data['abodemen'] = floatval($data['abodemen']);

        $data['total'] = str_replace(',', '', $data['total']);
        $data['total'] = str_replace('.00', '', $data['total']);
        $data['total'] = floatval($data['total']);

        $abodemen        = $data['abodemen'];
        $biaya_instalasi = $data['total'];

        $biaya_instal = $data['abodemen'] - $data['total'];
        // $biaya_pakai = $data['abodemen'] - $biaya_instal;

        $status = '0';
        $jumlah = $biaya_instal;
        if ($jumlah <= 0) {
            $status = 'P';
        }

        // INSTALLATION
        $install = Installations::create([
            'business_id' => Session::get('business_id'),
            'kode_instalasi' => $request->kode_instalasi,
            'customer_id' => $request->customer_id,
            'order' => Tanggal::tglNasional($request->order),
            'desa' => $request->desa,
            'alamat' => $request->alamat,
            'koordinate' => $request->koordinate,
            'package_id' => $request->package_id,
            'abodemen' => $abodemen,
            'biaya_instalasi' => $biaya_instalasi,
            'status' => $status,
        ]);

        // TRANSACTION TIDAK BOLEH NYICIL
        $jumlah_instal = ($biaya_instal >= 0) ? $biaya_instalasi : $abodemen;
        $persen = 100 - ($jumlah / $abodemen * 100);
        $transaksi = Transaction::create([
            'rekening_debit' => '1',
            'rekening_kredit' => '67',
            'tgl_transaksi' => Tanggal::tglNasional($request->order),
            'total' => $jumlah_instal,
            'installation_id' => $install->id,
            'keterangan' => 'Biaya istalasi ' . $persen . '%',
        ]);

        // TRANSACTION BOLEH NYICIL
        // if ($biaya_pakai <= 0) {
        //     $jumlah_pakai = $biaya_instal;
        //     $transaksi = Transaction::create([
        //         'rekening_debit' => '1',
        //         'rekening_kredit' => '59',
        //         'total' => $jumlah_pakai,
        //         'installation_id' => $install->id,
        //         'keterangan' => 'Biaya istalasi 1 bulan kedepan'
        //     ]);
        // }

        return response()->json([
            'success' => true,
            'msg' => 'Daftar & Instalasi berhasil disimpan',
            'installation' => $install
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Installations $installation)
    {
        $installation = $installation->with([
            'customer',
            'package',
            'village'
        ])->where('id', $installation->id)->first();

        $trx = transaction::where([
            ['installation_id', $installation->id],
            ['rekening_debit', '1'],
            ['rekening_kredit', '67']
        ])->sum('total');

        if ($installation->status == 'P' || $installation->status == '0') {
            $view = 'permohonan';
        } elseif ($installation->status == 'S') {
            $view = 'pasang';
        } elseif ($installation->status == 'A') {
            $view = 'aktif';
        } elseif ($installation->status == 'B') {
            $view = 'blokir';
        } elseif ($installation->status == 'C') {
            $view = 'cabut';
        } elseif ($installation->status == '0') {
            $view = 'belum_lunas';
        }

        return view('perguliran.partials/' . $view)->with(compact('installation', 'trx'));
    }

    public function edit_jenis_paket($id)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $package = Package::where('id', $id)->first();


        $tampil_settings = $pengaturan->first();
        return response()->json([
            'success' => true,
            'view' => view('perguliran.partials.edit_jenis_paket')->with(compact('tampil_settings', 'package'))->render()
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Installations $installation)
    {
        $paket = Package::all();
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $installations = $installation->with([
            'customer',
            'package',
            'usage',
            'village'
        ])->where('id', $installation->id)->first();
        $trx = transaction::where([
            ['installation_id', $installation->id],
            ['rekening_debit', '1'],
            ['rekening_kredit', '67']
        ])->sum('total');

        $tampil_settings = $pengaturan->first();
        $title = 'Edit Paket';

        if ($installations->status === '0') {
            return view('perguliran.partials.pasang')->with(compact('title', 'paket', 'trx', 'installations', 'tampil_settings'));
        } elseif ($installations->status === 'p') {
            return view('perguliran.partials.aktif_pasang')->with(compact('title', 'paket', 'trx', 'installations', 'tampil_settings'));
        } else {
            return view('perguliran.partials.edit_permohonan')->with(compact('title', 'paket', 'trx', 'installations', 'tampil_settings'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Installations $installation)
    {
        $data = $request->only([
            "order",
            "alamat",
            "koordinate"
        ]);
        $rules = [
            'order' => 'required|date', // ensures it's a valid date
            'alamat' => 'sometimes|string',
            'koordinate' => 'sometimes|string'
        ];
        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        // Update data 
        $update = Package::where('id', $installation->id)->update([
            'business_id' => Session::get('business_id'),
            'order_date' => $request->order,
            'alamat' => $request->alamat,
            'koordinate' => $request->koordinate
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Edit berhasil disimpan',
            'Editpermohonan' => $update
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Installations $installation)
    {
        // Menghapus Installations berdasarkan id yang diterima
        Installations::where('id', $installation->id)->delete();
        Transaction::where('installation_id', $installation->id)->delete();
        Usage::where('installation_id', $installation->id)->delete();

        // Redirect ke halaman Installations dengan pesan sukses
        return response()->json([
            'success' => true,
            'msg' => 'Permohonan berhasil dihapus',
            'installation' => $installation
        ]);
    }
}
