<?php

namespace App\Http\Controllers;

use App\Models\Cater;
use App\Models\Customer;
use App\Models\Family;
use App\Models\Installations;
use App\Models\Package;
use App\Models\Region;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\Account;
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
     * index menampilkan data per status.
     */
    public function index()
    {
        $installations = Installations::all();
        $status_R = Installations::whereIn('status', ['R', '0'])->with(
            'customer',
            'village',
            'package'
        )->get();
        $status_I = Installations::where('status', 'I')->with(
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

        $title = 'Permohonan';
        return view('perguliran.index')->with(compact('title', 'installations', 'status_R', 'status_I', 'status_A', 'status_B', 'status_C'));
    }

    /**
     * cari custommer trx instalasi.
     */
    public function CariPelunasanInstalasi(Request $request)
    {
        $query = $request->input('query');

        $customers = Customer::where(function ($q) use ($query) {
            $q->where('nama', 'LIKE', "%{$query}%")
                ->orWhere('nik', 'LIKE', "%{$query}%");
        })->with([
            'installation',
            'installation.transaction' => function ($query) {
                $query->where([
                    ['rekening_debit', '1'],
                    ['rekening_kredit', '67']
                ]);
            },
            'installation.village',
            'installation.package',
        ])->get();

        return response()->json($customers);
    }

    /**
     * cari custommers trx tagihan bulanan .
     */
    public function CariTagihanbulanan(Request $request)
    {
        $params = $request->input('query');

        $installations = Installations::select(
            'installations.*',
            'customers.nama',
            'customers.alamat',
            'customers.nik',
            'customers.hp'
        )
            ->join('customers', 'customers.id', 'installations.customer_id')->where(function ($query) use ($params) {
                $query->where('customers.nama', 'LIKE', "%{$params}%")
                    ->orWhere('customers.nik', 'LIKE', "%{$params}%")
                    ->orWhere('installations.kode_instalasi', 'LIKE', "%{$params}%");
            })->whereNotIn('installations.status', ['B', 'C'])->get();

        return response()->json($installations);
    }

    /**
     * cari & menampilkan data custommers trx tagihan bulanan .
     */
    public function usage($kode_instalasi)
    {
        $business_id = Session::get('business_id');
        $installations = Installations::where('kode_instalasi', $kode_instalasi)
            ->with([
                'package',
                'customer',
                'village',
                'settings'
            ])
            ->withSum([
                'transaction' => function ($query) {
                    $query->where([
                        ['rekening_debit', '1'],
                        ['rekening_kredit', '67']
                    ]);
                },
            ], 'total')->first();

        $pengaturan = Settings::where('business_id', $business_id);
        $trx_settings = $pengaturan->first();
        $package = Package::all();
        $transaksi = Transaction::all();

        $usages = Usage::where([
            ['id_instalasi', $installations->id],
            ['status', 'NOT LIKE', 'PAID']
        ])->get();

        $jumlah_trx = $installations->transaction_sum_total;
        $abodemen = $installations->abodemen;

        if ($jumlah_trx == $abodemen) {

            $tagihan1 = Account::where([
                ['kode_akun', '1.1.01.01'],
                ['business_id', Session::get('business_id')]
            ])->first();
            $tagihan2 = Account::where([
                ['kode_akun', '4.2.01.04'],
                ['business_id', Session::get('business_id')]
            ])->first();

            return response()->json([
                'success' => true,
                'view' => view('transaksi.partials.usage')->with(compact('installations', 'transaksi',  'usages', 'trx_settings', 'package'))->render(),
                'rek_debit' => $tagihan1,
                'rek_kredit' => $tagihan2,
            ]);
        } else {

            $pasang1 = Account::where([
                ['kode_akun', '1.1.01.01'],
                ['business_id', Session::get('business_id')]
            ])->first();
            $pasang2 = Account::where([
                ['kode_akun', '5.1.01.04'],
                ['business_id', Session::get('business_id')]
            ])->first();

            return response()->json([
                'success' => false,
                'view' => view('transaksi.partials.installations')->with(compact('installations', 'usages', 'trx_settings', 'package'))->render(),
                'rek_debit' => $pasang1,
                'rek_kredit' => $pasang2,
            ]);
        }
    }

    /**
     * kode instalasi register instalasi.
     */
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

    /**
     * jenis paket register instalasi.
     */
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
     * register instalasi.
     */

    public function create()
    {
        $paket = Package::all();
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $settings = $pengaturan->first();

        $caters = Cater::where('business_id', $business_id)->get();
        $customer = Customer::with('Village')->orderBy('id', 'ASC')->get();
        $desa = Village::all();

        $pilih_desa = 0;
        $title = 'Register Installlation';
        return view('perguliran.create')->with(compact('settings', 'paket', 'caters', 'customer', 'desa', 'pilih_desa', 'title'));
    }

    /**
     * register notifikasi jika belum lunas / blokir.
     */
    public function reg_notifikasi($customer_id)
    {
        $business_id = Session::get('business_id');
        $caters = Cater::where('business_id', $business_id)->get();
        $pengaturan = Settings::where('business_id', $business_id);
        $settings = $pengaturan->first();
        $paket = Package::all();
        $installations = Installations::all();
        $REG_status = Installations::select(
            'id',
            'status',
            'customer_id',
            'package_id',
            'abodemen',
            'koordinate',
            'kode_instalasi',
            'blokir',
            'cabut',
            'alamat'
        )->with(
            'customer',
            'package'
        )->where('customer_id', $customer_id)->orderBy('created_at', 'DESC')->first();


        $customer = Customer::with('Village')->orderBy('id', 'ASC')->get();
        $desa = Village::all();

        $pilih_desa = 0;
        $title = 'Register Installlation';

        if ($REG_status && ($REG_status->status == 'B' || $REG_status->status == 'C')) {
            $view = view('perguliran.partials.tangungan_pinjaman')->with(compact('REG_status', 'title'));
        } else {
            $view = view('perguliran.partials.form_installation')->with(compact('settings', 'caters', 'paket', 'installations', 'customer', 'desa', 'pilih_desa', 'title'));
        }

        return response()->json($view->render());
    }

    /**
     * proses simpan register instalasi.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            "customer_id",
            "order",
            "desa",
            "cater",
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
            'cater' => 'required',
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

        $status = '0';
        $jumlah = $biaya_instal;
        if ($jumlah <= 0) {
            $status = 'R';
        }

        // INSTALLATION = simpan database 
        $install = Installations::create([
            'business_id' => Session::get('business_id'),
            'kode_instalasi' => $request->kode_instalasi,
            'customer_id' => $request->customer_id,
            'cater_id' => $request->cater,
            'order' => Tanggal::tglNasional($request->order),
            'desa' => $request->desa,
            'alamat' => $request->alamat,
            'koordinate' => $request->koordinate,
            'package_id' => $request->package_id,
            'abodemen' => $abodemen,
            'biaya_instalasi' => $biaya_instalasi,
            'status' => $status,
        ]);

        // TRANSACTION = simpan database
        $jumlah_instal = ($biaya_instal >= 0) ? $biaya_instalasi : $abodemen;
        $persen = 100 - ($jumlah / $abodemen * 100);
        if ($jumlah_instal > 0) {
            $transaksi = Transaction::create([
                'rekening_debit' => '1',
                'rekening_kredit' => '67',
                'tgl_transaksi' => Tanggal::tglNasional($request->order),
                'total' => $jumlah_instal,
                'installation_id' => $install->id,
                'keterangan' => 'Biaya istalasi ' . $persen . '%',
            ]);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Daftar & Instalasi berhasil disimpan',
            'installation' => $install
        ]);
    }

    /**
     * Memecah dan menampilkan Detail di Status Instalasi.
     */
    public function show(Installations $installation)
    {
        $func = 'detail' . $installation->status;
        return $this->$func($installation);
    }
    /**
     * Menampilkan Detail dengan status 0.
     */
    private function detail0($installation)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $settings = $pengaturan->first();

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

        return view('perguliran.partials/permohonan')->with(compact('settings', 'installation', 'trx'));
    }
    /**
     * Menampilkan Detail dengan status R.
     */
    private function detailR($installation)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $settings = $pengaturan->first();

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

        return view('perguliran.partials/permohonan')->with(compact('settings', 'installation', 'trx'));
    }

    /**
     * Menampilkan Detail dengan status I.
     */
    private function detailI($installation)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        $tampil_settings = $pengaturan->first();

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

        return view('perguliran.partials/pasang')->with(compact('installation', 'tampil_settings', 'trx'));
    }

    /**
     * Menampilkan Detail dengan status A.
     */
    private function detailA($installation)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        $tampil_settings = $pengaturan->first();
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

        return view('perguliran.partials/aktif')->with(compact('installation', 'tampil_settings', 'trx'));
    }

    /**
     * Menampilkan Detail dengan status B.
     */
    private function detailB($installation)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        $tampil_settings = $pengaturan->first();
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

        return view('perguliran.partials/blokir')->with(compact('installation', 'tampil_settings', 'trx'));
    }

    /**
     * Menampilkan Detail dengan status C.
     */
    private function detailC($installation)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        $tampil_settings = $pengaturan->first();
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

        return view('perguliran.partials/copot')->with(compact('installation', 'tampil_settings', 'trx'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Installations $installation)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $settings = $pengaturan->first();
        $paket = Package::all();
        $customer = Customer::with('Village')->orderBy('id', 'ASC')->get();
        $installations = $installation->with([
            'customer',
            'package',
            'village'
        ])->where('id', $installation->id)->first();

        $desa = Village::all();

        $pilih_desa = 0;
        $title = 'Register Proposal';
        return view('perguliran.partials.edit_permohonan')->with(compact('settings', 'paket', 'installations', 'customer', 'desa', 'pilih_desa', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Installations $installation)
    {
        //progres simpan detail| $request->status = 0
        $func = 'update' . $request->status; // update0
        return $this->$func($request, $installation); // $this->update0()
        //end progres simpan detail
    }

    /**
     * Update Edit data.
     */
    private function updateEditData($request, $installation)
    {
        $data = $request->only([
            "order",
            "alamat",
            "koordinate"
        ]);

        $rules = [
            'order' => 'required',
            'alamat' => 'sometimes',
            'koordinate' => 'sometimes'
        ];
        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        // Update data 
        $update = Installations::where('id', $installation->id)->update([
            'business_id' => Session::get('business_id'),
            'order' => Tanggal::tglNasional($request->order),
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
     * Update Edit data Status 0.
     */
    private function update0($request, $installation)
    {
        $data = $request->only([
            "pasang",
        ]);

        $rules = [
            'pasang' => 'required',
        ];
        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        // Update data 
        $update = Installations::where('id', $installation->id)->update([
            'business_id' => Session::get('business_id'),
            'pasang' => Tanggal::tglNasional($request->pasang),
            'status' => 'I',
        ]);
        return response()->json([
            'success' => true,
            'msg' => 'Progres Pasang berhasil disimpan',
            'Pasang' => $installation
        ]);
    }

    /**
     * Update Detail Status R.
     */
    private function updateR($request, $installation)
    {
        $data = $request->only([
            "pasang",
        ]);

        $rules = [
            'pasang' => 'required',
        ];
        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        // Update data 
        $update = Installations::where('id', $installation->id)->update([
            'business_id' => Session::get('business_id'),
            'pasang' => Tanggal::tglNasional($request->pasang),
            'status' => 'I',
        ]);
        return response()->json([
            'success' => true,
            'msg' => 'Progres Pasang berhasil disimpan',
            'Pasang' => $installation
        ]);
    }

    /**
     * Update Detail Status I.
     */
    private function updateI($request, $installation)
    {
        $data = $request->only([
            "aktif",
        ]);

        $rules = [
            'aktif' => 'required',
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        // INSTALLATION
        $instal = Installations::where('id', $installation->id)->update([
            'business_id' => Session::get('business_id'),
            'aktif' => Tanggal::tglNasional($request->aktif),
            'status' => 'A',
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Daftar & Pemakaian awal berhasil disimpan',
            'aktif' => $installation
        ]);
    }

    /**
     * Update Detail Status A.
     */
    private function updateA($request, $installation)
    {
        $data = $request->only([
            "pasang_baru",
            "aktif",
            "total"
        ]);

        $rules = [
            'aktif' => 'required',
        ];
        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $data['pasang_baru'] = str_replace(',', '', $data['pasang_baru']);
        $data['pasang_baru'] = str_replace('.00', '', $data['pasang_baru']);
        $data['pasang_baru'] = floatval($data['pasang_baru']);

        $data['total'] = str_replace(',', '', $data['total']);
        $data['total'] = str_replace('.00', '', $data['total']);
        $data['total'] = floatval($data['total']);

        $pasang_baru        = $data['pasang_baru'];
        $biaya_instalasi = $data['total'];

        $biaya_instal = $pasang_baru - $biaya_instalasi;

        $status = '0';
        $jumlah = $biaya_instal;
        if ($jumlah <= 0) {
            $status = 'A';
        }
        // INSTALLATION
        $instal = Installations::where('id', $installation->id)->update([
            'business_id' => Session::get('business_id'),
            'aktif' => Tanggal::tglNasional($request->aktif),
            'status' => 'A',
        ]);

        // TRANSACTION TIDAK BOLEH NYICIL
        $jumlah_instal = ($biaya_instal >= 0) ? $biaya_instalasi : $pasang_baru;
        $persen = 100 - ($jumlah / $pasang_baru * 100);
        $transaksi = Transaction::create([
            'rekening_debit' => '1',
            'rekening_kredit' => '59',
            'tgl_transaksi' => Tanggal::tglNasional($request->aktif),
            'total' => $jumlah_instal,
            'installation_id' => $installation->id,
            'keterangan' => 'Biaya Pemakaian 1 bulan kedepan ' . $persen . '%',
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Daftar & Pemakaian awal berhasil disimpan',
            'aktif' => $installation
        ]);
    }

    /**
     * Update Detail Status B.
     */
    private function updateB($request, $installation)
    {
        $data = $request->only([
            "cabut",

        ]);

        $rules = [
            'cabut' => 'required',
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        // INSTALLATION
        $instal = Installations::where('id', $installation->id)->update([
            'business_id' => Session::get('business_id'),
            'cabut' => Tanggal::tglNasional($request->cabut),
            'status' => 'C',
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Pencabutan Custommer Berhasil',
            'cabut' => $installation
        ]);
    }

    /**
     * Update Detail Status B kembali menjaddi Aktif.
     */
    public function KembaliStatus_A($id)
    {
        $instal = Installations::where('id', $id)->update([
            'business_id' => Session::get('business_id'),
            'status' => 'A',
        ]);

        return response()->json([
            'success' => true,
            'msg' => '"Data berhasil diaktifkan dan statusnya dikembalikan menjadi Aktif."',
            'kembaliA' => $instal
        ]);
    }

    /**
     * menghapus data instalasi status R.
     */
    public function destroy(Installations $installation)
    {
        // Menghapus Installations berdasarkan id yang diterima
        Installations::where('id', $installation->id)->delete();
        Transaction::where('installation_id', $installation->id)->delete();
        Usage::where('id_instalasi', $installation->id)->delete();

        // Redirect ke halaman Installations dengan pesan sukses
        return response()->json([
            'success' => true,
            'msg' => 'Permohonan berhasil dihapus',
            'installation' => $installation
        ]);
    }
    public function list($cater_id)
    {
        $tanggal = request()->get('tanggal') ?: date('d/m/Y');
        $tanggal = Tanggal::tglNasional($tanggal);

        $installations = Installations::where('cater_id', $cater_id)->with([
            'oneUsage' => function ($query) use ($tanggal) {
                $query->where('tgl_akhir', '<=', $tanggal);
            },
            'customer'
        ])->get();

        return response()->json([
            'success' => true,
            'installations' => $installations
        ]);
    }
}
