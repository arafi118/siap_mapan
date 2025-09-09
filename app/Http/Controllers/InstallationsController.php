<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Installations;
use App\Models\Package;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Business;
use App\Models\Cater;
use App\Models\Usage;
use App\Models\User;
use App\Models\Village;
use App\Utils\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class InstallationsController extends Controller
{
    /**
     * index menampilkan data per status.
     */
    public function index()
    {
        // $status_R = Installations::where('business_id', Session::get('business_id'))->whereIn('status', ['R', '0'])->with(
        //     'customer',
        //     'village',
        //     'package'
        // )->get();
        // $status_I = Installations::where('business_id', Session::get('business_id'))->where('status', 'I')->with(
        //     'customer',
        //     'package'
        // )->get();
        // $status_A = Installations::where('business_id', Session::get('business_id'))->where('status', 'A')->with(
        //     'customer',
        //     'package'
        // )->get();
        // $status_B = Installations::where('business_id', Session::get('business_id'))->where('status', 'B')->with(
        //     'customer',
        //     'package'
        // )->get();
        // $status_C = Installations::where('business_id', Session::get('business_id'))->where('status', 'C')->with(
        //     'customer',
        //     'package'
        // )->get();

        if (request()->ajax()) {
            $status = explode(',', request()->get('status'));
            $installations = Installations::where('installations.business_id', Session::get('business_id'))->whereIn('installations.status', $status)->with(
                'customer',
                'village',
                'package'
            );

            return DataTables::eloquent($installations)
                ->addColumn('aksi', function ($row) {
                    $view = '<div class="btn-group"><a href="/installations/' . $row->id . '" class="btn btn-info btn-sm btn-data btn-detail"><i class="fas fa-info-circle"></i></a>';
                    if ($row->status == 'R') {
                        $view .= '<a href="/installations/' . $row->id . '/edit" class="btn btn-warning btn-sm btn-data btn-edit"><i class="fas fa-exclamation-triangle"></i></a>';
                        $view .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-data btn-hapus Hapus_id"><i class="fas fa-trash"></i></a>';
                    }
                    $view .= '</div>';

                    return $view;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        $title = 'Permohonan';
        return view('perguliran.index')->with(compact('title'));
    }

    public function DaftarInstalasi()
    {
        $installations = Installations::where('business_id', Session::get('business_id'))
            ->with([
                'customer',
                'package',
                'village',
                'users'
            ])->get();
        $title = 'Data Intalasi';
        return view('perguliran.partials.DaftarInstalasi')->with(compact('title', 'installations'));
    }

    /**
     * cari custommer trx instalasi.
     */
    public function CariPelunasanInstalasi(Request $request)
    {
        $query = $request->input('query');

        // Cari akun berdasarkan kode_akun
        $rekening_debit = Account::where([
            ['kode_akun', '1.1.01.01'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $rekening_kredit = Account::where([
            ['kode_akun', '4.1.01.01'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $customers = Customer::where('business_id', Session::get('business_id'))
            ->where(function ($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                    ->orWhere('nik', 'LIKE', "%{$query}%");
            })
            ->with([
                'installation',
                'installation.transaction' => function ($q) use ($rekening_debit, $rekening_kredit) {
                    if ($rekening_debit && $rekening_kredit) {
                        $q->where([
                            ['rekening_debit', $rekening_debit->id],
                            ['rekening_kredit', $rekening_kredit->id]
                        ]);
                    }
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
            'customers.hp',
            'packages.inisial as package_inisial' // alias agar jelas di JS
        )
            ->join('customers', 'customers.id', '=', 'installations.customer_id')
            ->leftJoin('packages', 'packages.id', '=', 'installations.package_id') // tambahkan ini
            ->where(function ($query) use ($params) {
                $query->where('customers.nama', 'LIKE', "%{$params}%")
                    ->orWhere('customers.nik', 'LIKE', "%{$params}%")
                    ->orWhere('installations.kode_instalasi', 'LIKE', "%{$params}%");
            })
            ->where(function ($query) {
                $query->where('installations.business_id', Session::get('business_id'))
                    ->orWhere('customers.business_id', Session::get('business_id'));
            })
            ->whereNotIn('installations.status', ['B', 'C'])
            ->get();


        return response()->json($installations);
    }

    /**
     * cari & menampilkan data custommers trx tagihan bulanan .
     */
    public function usage($kode_instalasi)
    {
        $business_id = Session::get('business_id');

        $rekening_debit = Account::where([
            ['kode_akun', '1.1.01.01'],
            ['business_id', $business_id]
        ])->first();

        $rekening_kredit = Account::where([
            ['kode_akun', '4.1.01.03'],
            ['business_id', $business_id]
        ])->first();

        $rekening_denda = Account::where([
            ['kode_akun', '4.1.01.04'],
            ['business_id', $business_id]
        ])->first();

        $rekening_piutang = Account::where([
            ['kode_akun', '1.1.03.01'],
            ['business_id', $business_id]
        ])->first();

        $installations = Installations::where('kode_instalasi', $kode_instalasi)->where('business_id', Session::get('business_id'))
            ->with([
                'package',
                'customer',
                'village',
                'settings',
                'users' => function ($query) {
                    $query->where('jabatan', '5');
                },
            ])
            ->withSum([
                'transaction' => function ($query) use ($rekening_debit, $rekening_kredit) {
                    if ($rekening_debit && $rekening_kredit) {
                        $query->where([
                            ['rekening_debit', $rekening_debit->id],
                            ['rekening_kredit', $rekening_kredit->id]
                        ]);
                    }
                },
            ], 'total')
            ->with([
                'transaction' => function ($query) use ($rekening_denda, $rekening_piutang) {
                    $query->where([
                        ['rekening_kredit', $rekening_denda->id],
                        ['rekening_debit', $rekening_piutang->id]
                    ]);
                }
            ])
            ->first();

        $pengaturan = Settings::where('business_id', $business_id);
        $trx_settings = $pengaturan->first();
        $usages = Usage::where('business_id', Session::get('business_id'))->where([
            ['id_instalasi', $installations->id],
            ['status', '=', 'UNPAID']
        ])->orderBy('tgl_pemakaian', 'DESC')->get();

        $jumlah_trx = $installations->transaction_sum_total;
        $biaya_instal = $installations->biaya_instalasi;

        $tagihan1 = Account::where('business_id', Session::get('business_id'))->where([
            ['kode_akun', '1.1.01.01'],
            ['business_id', Session::get('business_id')]
        ])->first();
        $tagihan2 = Account::where('business_id', Session::get('business_id'))->where([
            ['kode_akun', '4.2.01.04'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $qr = QrCode::generate($installations->id);

        return response()->json([
            'success' => true,
            'view' => view('transaksi.partials.usage')->with(compact('qr', 'installations',  'usages', 'trx_settings'))->render(),
            'rek_debit' => $tagihan1,
            'rek_kredit' => $tagihan2,
        ]);
        if ($jumlah_trx == $biaya_instal) {
        } else {

            $pasang1 = Account::where('business_id', Session::get('business_id'))->where([
                ['kode_akun', '1.1.01.01'],
                ['business_id', Session::get('business_id')]
            ])->first();
            $pasang2 = Account::where('business_id', Session::get('business_id'))->where([
                ['kode_akun', '5.1.01.04'],
                ['business_id', Session::get('business_id')]
            ])->first();

            return response()->json([
                'success' => false,
                'view' => view('transaksi.partials.installations')->with(compact('qr', 'installations', 'usages', 'trx_settings', 'package'))->render(),
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
        $bisnis = Session::get('business_id');
        $kd_desa = request()->get('kode_desa');
        $rt = request()->get('kode_rt');

        $jumlah_kode_instalasi_by_desa = Installations::where('business_id', Session::get('business_id'))->where('desa', $kd_desa)->orderBy('kode_instalasi', 'DESC');

        $desa = Village::where('id', $kd_desa)->first();
        $kd_bisnis = substr($desa->kode, 0, 3);
        $kd_desa = substr($desa->kode, 4, 4);
        $kd_dusun = substr($desa->kode, 9,);

        $kode_instalasi = $bisnis . '.' . $kd_dusun  . '.' .  $rt;

        if ($jumlah_kode_instalasi_by_desa->count() > 0) {
            $jumlah = str_pad(($jumlah_kode_instalasi_by_desa->count() + 1), 3, "0", STR_PAD_LEFT);
        } else {
            $jumlah = str_pad(Installations::where('business_id', Session::get('business_id'))->where('desa', $kd_desa)->count() + 1, 3, "0", STR_PAD_LEFT);
        }

        $kode_instalasi .= '.' . $jumlah;

        if (request()->get('kd_instalasi')) {
            $kd_ins = request()->get('kd_instalasi');
            $instalasi = Installations::where('business_id', Session::get('business_id'))->where('kd_instalasi', $kd_ins);
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
        $package = Package::where('business_id', Session::get('business_id'))->where('id', $id)->first();


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
        $paket = Package::where('business_id', Session::get('business_id'))->get();
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $settings = $pengaturan->first();

        $caters = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '5']
        ])->get();
        $customer = Customer::where('business_id', Session::get('business_id'))->with('Village')->orderBy('id', 'ASC')->get();
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
        $caters = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '5']
        ])->get();
        $pengaturan = Settings::where('business_id', $business_id);
        $settings = $pengaturan->first();
        $paket = Package::where('business_id', Session::get('business_id'))->get();
        $installations = Installations::where('business_id', Session::get('business_id'))->get();
        $REG_status = Installations::where('business_id', Session::get('business_id'))->select(
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


        $customer = Customer::where('business_id', Session::get('business_id'))->with('Village')->orderBy('id', 'ASC')->get();
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
            "jalan",
            "rw",
            "rt",
            "koordinate",
            "package_id",
            "pasang_baru",
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
            'jalan' => 'required',
            'rw' => 'required',
            'rt' => 'required',
            'koordinate' => 'required',
            'package_id' => 'required'
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $data['pasang_baru'] = str_replace(',', '', $data['pasang_baru']);
        $data['pasang_baru'] = str_replace('.00', '', $data['pasang_baru']);
        $data['pasang_baru'] = floatval($data['pasang_baru']);

        $data['abodemen'] = str_replace(',', '', $data['abodemen']);
        $data['abodemen'] = str_replace('.00', '', $data['abodemen']);
        $data['abodemen'] = floatval($data['abodemen']);

        $data['total'] = str_replace(',', '', $data['total']);
        $data['total'] = str_replace('.00', '', $data['total']);
        $data['total'] = floatval($data['total']);

        $pasangbaru        = $data['pasang_baru'];
        $abodemen          = $data['abodemen'];
        $biaya_instalasi   = $data['total'];

        $biaya_instal = $pasangbaru - $biaya_instalasi;

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
            'alamat' => $request->jalan,
            'rw' => $request->rw,
            'rt' => $request->rt,
            'koordinate' => $request->koordinate,
            'package_id' => $request->package_id,
            'abodemen' => $abodemen,
            'biaya_instalasi' => $pasangbaru,
            'status' => $status,
        ]);

        // TRANSACTION = simpan database
        $jumlah_instal = ($biaya_instal >= 0) ? $biaya_instalasi : $pasangbaru;

        $perse = round(100 - ($jumlah / $pasangbaru * 100));
        $persen = max(1, min($perse, 100));

        if ($jumlah_instal > 0) {
            $business_id = Session::get('business_id');
            $rekening_debit = Account::where([
                ['kode_akun', '1.1.01.01'],
                ['business_id', $business_id]
            ])->first();

            $rekening_kredit = Account::where([
                ['kode_akun', '4.1.01.01'],
                ['business_id', $business_id]
            ])->first();

            if ($rekening_debit && $rekening_kredit) {
                $transaksi = Transaction::create([
                    'business_id' => Session::get('business_id'),
                    'rekening_debit' => $rekening_debit->id,
                    'rekening_kredit' => $rekening_kredit->id,
                    'tgl_transaksi' => Tanggal::tglNasional($request->order),
                    'total' => $jumlah_instal,
                    'installation_id' => $install->id,
                    'keterangan' => 'Biaya instalasi ' . $persen . '%',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Rekening tidak ditemukan, transaksi gagal'
                ], 400);
            }
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
    private function detail0(Request $request, $installation)
    {
        $business_id = Session::get('business_id');
        $settings = Settings::where('business_id', $business_id)->first();
        $installation = $installation->with([
            'customer',
            'package',
            'village'
        ])->where('id', $installation->id)->first();
        $rekening_debit = Account::where([
            ['kode_akun', '1.1.01.01'],
            ['business_id', $business_id]
        ])->first();
        $rekening_kredit = Account::where([
            ['kode_akun', '4.1.01.01'],
            ['business_id', $business_id]
        ])->first();

        $trx = Transaction::where([
            ['installation_id', $installation->id],
            ['rekening_debit', $rekening_debit->id],
            ['rekening_kredit', $rekening_kredit->id]
        ])->sum('total');
        $qr = QrCode::generate($installation->id);
        return view('perguliran.partials.permohonan')->with(compact('settings', 'installation', 'trx', 'qr'));
    }

    /**
     * Menampilkan Detail dengan status R.
     */
    private function detailR($installation)
    {
        $business_id = Session::get('business_id');
        $settings = Settings::where('business_id', $business_id)->first();
        $installation = $installation->with([
            'customer',
            'package',
            'village'
        ])->where('id', $installation->id)->first();

        $rekening_debit = Account::where([
            ['kode_akun', '1.1.01.01'],
            ['business_id', $business_id]
        ])->first();

        $rekening_kredit = Account::where([
            ['kode_akun', '4.1.01.01'],
            ['business_id', $business_id]
        ])->first();

        $trx = Transaction::where([
            ['installation_id', $installation->id],
            ['rekening_debit', $rekening_debit->id],
            ['rekening_kredit', $rekening_kredit->id]
        ])->sum('total');
        $qr = QrCode::generate($installation->id);

        return view('perguliran.partials.permohonan')->with(compact('settings', 'installation', 'trx', 'qr'));
    }
    /**
     * Menampilkan Detail dengan status I.
     */
    private function detailI($installation)
    {
        $business_id = Session::get('business_id');
        $tampil_settings = Settings::where('business_id', $business_id)->first();

        $installation = $installation->with([
            'customer',
            'package',
            'village'
        ])->where('id', $installation->id)->first();

        $rekening_debit = Account::where([
            ['kode_akun', '1.1.01.01'],
            ['business_id', $business_id]
        ])->first();

        $rekening_kredit = Account::where([
            ['kode_akun', '4.1.01.01'],
            ['business_id', $business_id]
        ])->first();

        $trx = Transaction::where([
            ['installation_id', $installation->id],
            ['rekening_debit', $rekening_debit->id],
            ['rekening_kredit', $rekening_kredit->id]
        ])->sum('total');
        $qr = QrCode::generate($installation->id);

        return view('perguliran.partials.pasang')->with(compact('installation', 'tampil_settings', 'trx', 'qr'));
    }


    /**
     * Menampilkan Detail dengan status A.
     */
    private function detailA(Installations $installation)
    {
        $business_id = Session::get('business_id');
        $tampil_settings = Settings::where('business_id', $business_id)->first();

        $rekening_debit = Account::where([
            ['kode_akun', '1.1.01.01'],
            ['business_id', $business_id]
        ])->first();

        $rekening_kredit = Account::where([
            ['kode_akun', '4.1.01.03'],
            ['business_id', $business_id]
        ])->first();
        $trx = Transaction::where([
            ['installation_id', $installation->id],
            ['rekening_debit', $rekening_debit->id],
            ['rekening_kredit', $rekening_kredit->id]
        ])->sum('total');
        $qr = QrCode::generate($installation->id);

        return view('perguliran.partials.aktif')->with(compact('installation', 'tampil_settings', 'trx', 'qr'));
    }

    /**
     * Menampilkan Detail dengan status B.
     */
    private function detailB($installation)
    {
        $business_id = Session::get('business_id');
        $tampil_settings = Settings::where('business_id', $business_id)->first();
        $installation = $installation->with([
            'customer',
            'package',
            'village'
        ])->where('id', $installation->id)->first();
        $rekening_debit = Account::where([
            ['kode_akun', '1.1.01.01'],
            ['business_id', $business_id]
        ])->first();

        $rekening_kredit = Account::where([
            ['kode_akun', '4.1.01.03'],
            ['business_id', $business_id]
        ])->first();
        $trx = Transaction::where([
            ['installation_id', $installation->id],
            ['rekening_debit', $rekening_debit->id],
            ['rekening_kredit', $rekening_kredit->id]
        ])->sum('total');
        $qr = QrCode::generate($installation->id);

        return view('perguliran.partials.blokir')->with(compact('installation', 'tampil_settings', 'trx', 'qr'));
    }

    /**
     * Menampilkan Detail dengan status C.
     */
    private function detailC($installation)
    {
        $business_id = Session::get('business_id');
        $tampil_settings = Settings::where('business_id', $business_id)->first();

        $installation = $installation->with([
            'customer',
            'package',
            'village'
        ])->where('id', $installation->id)->first();

        $rekening_debit = Account::where([
            ['kode_akun', '1.1.01.01'],
            ['business_id', $business_id]
        ])->first();

        $rekening_kredit = Account::where([
            ['kode_akun', '4.1.01.03'],
            ['business_id', $business_id]
        ])->first();

        $trx = Transaction::where([
            ['installation_id', $installation->id],
            ['rekening_debit', $rekening_debit->id],
            ['rekening_kredit', $rekening_kredit->id]
        ])->sum('total');
        $qr = QrCode::generate($installation->id);
        return view('perguliran.partials.copot')->with(compact('installation', 'tampil_settings', 'trx', 'qr'));
    }

    public function cetak_pemakaian(Installations $installation)
    {
        $keuangan = new Keuangan;
        $bisnis = Business::where('id', Session::get('business_id'))->first();
        $installation = $installation->with([
            'customer',
            'package',
            'village'
        ])->where('id', $installation->id)->first();
        // $logo = $bisnis->logo; 

        // $data['gambar'] = $logo;

        $data['gambar'] = $bisnis->logo;
        $data['keuangan'] = $keuangan;
        $data['qr'] = QrCode::size(50)->generate((string) $installation->id);
        $data['installation'] = $installation;
        $data['bisnis'] = $bisnis;

        return view('perguliran.partials.cetak', $data);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Installations $installation)
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $settings = $pengaturan->first();
        $paket = Package::where('business_id', Session::get('business_id'))->get();
        $customer = Customer::where('business_id', Session::get('business_id'))->with('Village')->orderBy('id', 'ASC')->get();
        $installations = $installation->with([
            'customer',
            'package',
            'village'
        ])->where('id', $installation->id)->first();

        $caters = User::where([
            ['business_id', Session::get('business_id')],
            ['jabatan', '5']
        ])->get();

        $desa = Village::all();

        $qr = QrCode::generate($installations->id);

        $pilih_desa = 0;
        $title = 'Register Proposal';
        return view('perguliran.partials.edit_permohonan')->with(compact('settings', 'qr', 'caters', 'paket', 'installations', 'customer', 'desa', 'pilih_desa', 'title'));
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
        $update = Installations::where('business_id', Session::get('business_id'))->where('id', $installation->id)->update([
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
        $update = Installations::where('business_id', Session::get('business_id'))->where('id', $installation->id)->update([
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
        $update = Installations::where('business_id', Session::get('business_id'))->where('id', $installation->id)->update([
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
        $instal = Installations::where('business_id', Session::get('business_id'))->where('id', $installation->id)->update([
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
        $instal = Installations::where('business_id', Session::get('business_id'))->where('id', $installation->id)->update([
            'business_id' => Session::get('business_id'),
            'aktif' => Tanggal::tglNasional($request->aktif),
            'status' => 'A',
        ]);

        // TRANSACTION TIDAK BOLEH NYICIL
        $jumlah_instal = ($biaya_instal >= 0) ? $biaya_instalasi : $pasang_baru;
        $persen = 100 - ($jumlah / $pasang_baru * 100);
        $transaksi = Transaction::create([
            'business_id' => Session::get('business_id'),
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
        $instal = Installations::where('business_id', Session::get('business_id'))->where('id', $installation->id)->update([
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
        $instal = Installations::where('business_id', Session::get('business_id'))->where('id', $id)->update([
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
    public function list($cater_id = 0)
    {
        $tanggal = request()->get('tanggal') ?: date('d/m/Y');
        $tgl_kondisi = Carbon::createFromFormat('d/m/Y', $tanggal)->format('Y-m'); // Hasil: "2025-05"
        if ($cater_id == '0') {
            return response()->json([
                'success' => true,
                'installations' => []
            ]);
        }

        $usedInstallationIds = Usage::where('business_id', Session::get('business_id'))
            ->where('cater', $cater_id)
            ->where('tgl_pemakaian', 'like', $tgl_kondisi . '%')
            ->pluck('id_instalasi');

        $installasi = Installations::select('installations.*')->where('installations.business_id', Session::get('business_id'))
            ->where('installations.cater_id', $cater_id)
            ->whereNotIn('installations.id', $usedInstallationIds)
            ->with(['customer', 'package', 'users', 'oneUsage', 'village']);

        if (request()->get('installation_id')) {
            $installation_id = request()->get('installation_id');
            $installasi = $installasi->where('installations.id', $installation_id);
        }

        return DataTables::eloquent($installasi)
            ->addColumn('akhir', function ($ins) use ($tgl_kondisi) {
                $tgl_kondisi = $tgl_kondisi . '-01';
                $tgl_akhir = $ins->oneUsage ? date('Y-m', strtotime($ins->oneUsage->tgl_akhir)) . '-01' : $tgl_kondisi;

                $allowInput = 'false';
                $textColor = 'text-danger';
                if ($tgl_akhir <= $tgl_kondisi) {
                    $allowInput = 'true';
                    $textColor = 'text-warning';
                }

                $akhir = 0;
                if ($ins->oneUsage) {
                    $akhir = $ins->oneUsage->akhir;
                }

                return '<div class="' . $textColor . ' text-right" data-allow-input="' . $allowInput . '">' . $akhir . '</div>';
            })
            ->rawColumns(['akhir'])
            ->make(true);
    }
}
