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
use App\Models\Account;
use App\Models\Business;
use App\Models\User;
use App\Models\JenisTransactions;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;
use App\Utils\Inventaris as UtilsInventaris;
use App\Utils\Keuangan;
use DB;
use PDF;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();

        $title = ' Transaksi';
        return view('transaksi.index')->with(compact('title', 'transactions'));
    }
    //tampil jurnal umum
    public function jurnal_umum()
    {
        $transactions = Transaction::all();
        $jenis_transaksi = JenisTransactions::all();
        $rekening = Account::all();
        $business = Business::where('id', Session::get('business_id'))->first();

        $title = ' Transaksi';
        return view('transaksi.jurnal_umum.index')->with(compact('title', 'business', 'rekening', 'transactions', 'jenis_transaksi'));
    }
    //tampil pelunasan instalasi
    public function pelunasan_instalasi()
    {
        $transactions = Transaction::all();
        $installations = Installations::all();
        $status_0 = Installations::where('status', '0')->with(
            'customer',
            'village',
            'package'
        )->get();
        $title = 'Pelunasan Instalasi';
        return view('transaksi.pelunasan_instalasi')->with(compact('title', 'transactions', 'status_0'));
    }
    //tampil tagihan_bulanan
    public function tagihan_bulanan()
    {
        $transactions = Transaction::all();
        $installations = Installations::all();
        $settings = Settings::all();
        $status_0 = Installations::where('status', '0')->with(
            'customer',
            'village',
            'package'
        )->get();

        $title = 'Pelunasan Instalasi';
        return view('transaksi.tagihan_bulanan')->with(compact('title', 'transactions', 'status_0'));
    }
    //tampil rekening jurnal umum
    public function rekening($id)
    {
        $jenis_transaksi = JenisTransactions::where('id', $id)->firstOrFail();

        $label1 = 'Pilih Sumber Dana';
        $tahun = request()->get('tahun', date('Y'));
        $bulan = request()->get('bulan', date('m'));
        $tgl_kondisi = date('Y-m-t', strtotime($tahun . '-' . $bulan . '-01'));

        if ($id == 1) {
            $rek1 = Account::where(function ($query) {
                $query->where(function ($query) {
                    $query->where('lev1', '2')->orWhere('lev1', '3')->orWhere('lev1', '4');
                })->where([
                    ['kode_akun', '!=', '2.1.04.01'],
                    ['kode_akun', '!=', '2.1.04.02'],
                    ['kode_akun', '!=', '2.1.04.03'],
                    ['kode_akun', '!=', '2.1.02.01'],
                    ['kode_akun', '!=', '2.1.03.01'],
                    ['kode_akun', 'NOT LIKE', '4.1.01%'],
                ]);
            })->orderBy('kode_akun', 'ASC')->get();

            $rek2 = Account::where('lev1', '1')->orderBy('kode_akun', 'ASC')->get();

            $label2 = 'Disimpan Ke';
        } elseif ($id == 2) {
            $rek1 = Account::where(function ($query) {
                $query->where(function ($query) {
                    $query->where('lev1', '1')->orWhere('lev1', '2');
                })->where([
                    ['kode_akun', 'NOT LIKE', '2.1.04%'],
                ]);
            })->where(function ($query) use ($tgl_kondisi) {
                $query->whereNull('tgl_nonaktif')->orWhere('tgl_nonaktif', '>', $tgl_kondisi);
            })->orderBy('kode_akun', 'ASC')->get();

            $rek2 = Account::where('lev1', '2')->orWhere('lev1', '3')->orWhere('lev1', '5')->orderBy('kode_akun', 'ASC')->get();

            $label2 = 'Keperluan';
        } elseif ($id == 3) {
            $rek1 = Account::whereNull('tgl_nonaktif')->orWhere('tgl_nonaktif', '>', $tgl_kondisi)->get();

            $rek2 = Account::whereNull('tgl_nonaktif')->orWhere('tgl_nonaktif', '>', $tgl_kondisi)->get();

            $label2 = 'Disimpan Ke';
        }

        return view('transaksi.jurnal_umum.partials.rekening', compact('rek1', 'rek2', 'label1', 'label2'));
    }
    //tampil form rekening jurnal umum
    public function form()
    {
        $keuangan = new Keuangan;
        $tgl_transaksi = Tanggal::tglNasional(request()->get('tgl_transaksi'));
        $jenis_transaksi = request()->get('jenis_transaksi');

        $sumber_dana_id = request()->get('sumber_dana');
        $disimpan_ke_id = request()->get('disimpan_ke');

        // Ambil kode_akun dari tabel Account berdasarkan id
        $sumber_dana = Account::where('id', $sumber_dana_id)->value('kode_akun');
        $disimpan_ke = Account::where('id', $disimpan_ke_id)->value('kode_akun');


        if (Keuangan::startWith($sumber_dana, '1.2.01') && Keuangan::startWith($disimpan_ke, '5.3.02.01') && $jenis_transaksi == 2) {
            $kode = explode('.', $sumber_dana);
            $jenis = intval($kode[2]);
            $kategori = intval($kode[3]);

            $inventaris = Inventory::where([
                ['jenis', $jenis],
                ['kategori', $kategori]
            ])->whereNotNull('tgl_beli')->where(function ($query) {
                $query->where('status', 'Baik')->orwhere('status', 'Rusak');
            })->get();
            return view('transaksi.jurnal_umum.partials.form_hapus_inventaris')->with(compact('inventaris', 'tgl_transaksi'));
        } else {
            if (Keuangan::startWith($disimpan_ke, '1.2.01') || Keuangan::startWith($disimpan_ke, '1.2.03')) {
                $kuitansi = false;
                $relasi = false;
                $files = 'bm';
                if (Keuangan::startWith($disimpan_ke, '1.1.01') && !Keuangan::startWith($sumber_dana, '1.1.01')) {
                    $file = "c_bkm";
                    $files = "BKM";
                    $kuitansi = true;
                    $relasi = true;
                } elseif (!Keuangan::startWith($disimpan_ke, '1.1.01') && Keuangan::startWith($sumber_dana, '1.1.01')) {
                    $file = "c_bkk";
                    $files = "BKK";
                    $kuitansi = true;
                    $relasi = true;
                } elseif (Keuangan::startWith($disimpan_ke, '1.1.01') && Keuangan::startWith($sumber_dana, '1.1.01')) {
                    $file = "c_bm";
                    $files = "BM";
                } elseif (Keuangan::startWith($disimpan_ke, '1.1.02') && !(Keuangan::startWith($sumber_dana, '1.1.01') || Keuangan::startWith($sumber_dana, '1.1.02'))) {
                    $file = "c_bkm";
                    $files = "BKM";
                    $kuitansi = true;
                    $relasi = true;
                } elseif (Keuangan::startWith($disimpan_ke, '1.1.02') && Keuangan::startWith($sumber_dana, '1.1.02')) {
                    $file = "c_bm";
                    $files = "BM";
                } elseif (Keuangan::startWith($disimpan_ke, '5.') && !(Keuangan::startWith($sumber_dana, '1.1.01') || Keuangan::startWith($sumber_dana, '1.1.02'))) {
                    $file = "c_bm";
                    $files = "BM";
                } elseif (!(Keuangan::startWith($disimpan_ke, '1.1.01') || Keuangan::startWith($disimpan_ke, '1.1.02')) && Keuangan::startWith($sumber_dana, '1.1.02')) {
                    $file = "c_bm";
                    $files = "BM";
                } elseif (!(Keuangan::startWith($disimpan_ke, '1.1.01') || Keuangan::startWith($disimpan_ke, '1.1.02')) && Keuangan::startWith($sumber_dana, '4.')) {
                    $file = "c_bm";
                    $files = "BM";
                }

                return view('transaksi.jurnal_umum.partials.form_inventaris')->with(compact('relasi'));
            } else {
                $rek_sumber = Account::where('id', $sumber_dana)->first();
                $rek_simpan = Account::where('id', $disimpan_ke)->first();

                $keterangan_transaksi = '';
                if ($jenis_transaksi == 1) {
                    if (!empty($disimpan_ke)) {
                        $keterangan_transaksi = "Dari " . $rek_sumber->nama_akun . " ke " . $rek_simpan->nama_akun;
                    }
                } else if ($jenis_transaksi == 2) {
                    if (!empty($disimpan_ke)) {
                        $keterangan_transaksi = $rek_simpan->nama_akun;
                        $kd = substr($sumber_dana, 0, 6);
                        if ($kd == '1.1.01') {
                            $keterangan_transaksi = "Bayar " . $rek_simpan->nama_akun;
                        }
                        if ($kd == '1.1.02') {
                            $keterangan_transaksi = "Transfer " . $rek_simpan->nama_akun;
                        }
                    }
                } else if ($jenis_transaksi == 3) {
                    if (!empty($disimpan_ke)) {
                        $keterangan_transaksi = "Pemindahan Saldo " . $rek_sumber->nama_akun . " ke " . $rek_simpan->nama_akun;
                    }
                }

                $kuitansi = false;
                $relasi = false;
                $files = 'bm';
                if (Keuangan::startWith($disimpan_ke, '1.1.01') && !Keuangan::startWith($sumber_dana, '1.1.01')) {
                    $file = "c_bkm";
                    $files = "BKM";
                    $kuitansi = true;
                    $relasi = true;
                } elseif (!Keuangan::startWith($disimpan_ke, '1.1.01') && Keuangan::startWith($sumber_dana, '1.1.01')) {
                    $file = "c_bkk";
                    $files = "BKK";
                    $kuitansi = true;
                    $relasi = true;
                } elseif (Keuangan::startWith($disimpan_ke, '1.1.01') && Keuangan::startWith($sumber_dana, '1.1.01')) {
                    $file = "c_bm";
                    $files = "BM";
                } elseif (Keuangan::startWith($disimpan_ke, '1.1.02') && !(Keuangan::startWith($sumber_dana, '1.1.01') || Keuangan::startWith($sumber_dana, '1.1.02'))) {
                    $file = "c_bkm";
                    $files = "BKM";
                    $kuitansi = true;
                    $relasi = true;
                } elseif (Keuangan::startWith($disimpan_ke, '1.1.02') && Keuangan::startWith($sumber_dana, '1.1.02')) {
                    $file = "c_bm";
                    $files = "BM";
                } elseif (Keuangan::startWith($disimpan_ke, '5.') && !(Keuangan::startWith($sumber_dana, '1.1.01') || Keuangan::startWith($sumber_dana, '1.1.02'))) {
                    $file = "c_bm";
                    $files = "BM";
                } elseif (!(Keuangan::startWith($disimpan_ke, '1.1.01') || Keuangan::startWith($disimpan_ke, '1.1.02')) && Keuangan::startWith($sumber_dana, '1.1.02')) {
                    $file = "c_bm";
                    $files = "BM";
                } elseif (!(Keuangan::startWith($disimpan_ke, '1.1.01') || Keuangan::startWith($disimpan_ke, '1.1.02')) && Keuangan::startWith($sumber_dana, '4.')) {
                    $file = "c_bm";
                    $files = "BM";
                }

                $susut = 0;
                if (Keuangan::startWith($disimpan_ke, '5.1.07.10')) {
                    $tanggal = date('Y-m-t', strtotime($tgl_transaksi));
                    if ($sumber_dana == '1.2.02.01') {
                        $kategori = '2';
                    } elseif ($sumber_dana == '1.2.02.02') {
                        $kategori = '3';
                    } else {
                        $kategori = '4';
                    }

                    $penyusutan = UtilsInventaris::penyusutan($tanggal, $kategori);
                    $saldo = UtilsInventaris::saldoSusut($tanggal, $sumber_dana);

                    $susut = $penyusutan - $saldo;
                    if ($susut < 0) $susut *= -1;
                    $keterangan_transaksi .= ' (' . Tanggal::namaBulan($tgl_transaksi) . ')';
                }

                return view('transaksi.jurnal_umum.partials.form_nominal')->with(compact('relasi', 'keterangan_transaksi', 'susut'));
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $func = 'Create' . $request->clay;
        return $this->$func($request);
    }

    /**
     *  CreateJurnalUmum.
     */
    private function CreateJurnalUmum($request)
    {
        $keuangan = new Keuangan;

        $tgl_transaksi = Tanggal::tglNasional($request->tgl_transaksi);
        $bisnis = Business::where('id', Session::get('business_id'))->first();
        $sumber_dana_id = request()->get('sumber_dana');
        $disimpan_ke_id = request()->get('disimpan_ke');

        // Ambil kode_akun dari tabel Account berdasarkan id
        $sumber_dana = Account::where('id', $sumber_dana_id)->value('kode_akun');
        $disimpan_ke = Account::where('id', $disimpan_ke_id)->value('kode_akun');

        if (strtotime($tgl_transaksi) < strtotime($bisnis->tgl_pakai)) {
            return response()->json([
                'success' => false,
                'msg' => 'Tanggal transaksi tidak boleh sebelum Tanggal Pakai Aplikasi'
            ]);
        }

        if (Keuangan::startWith($sumber_dana, '1.2.01') && Keuangan::startWith($disimpan_ke, '5.3.02.01') && $request->jenis_transaksi == '2') {
            $data = $request->only([
                'tgl_transaksi',
                'jenis_transaksi',
                'sumber_dana',
                'disimpan_ke',
                'harsat',
                'nama_barang',
                'alasan',
                'unit',
                'harga_jual',
                '_nilai_buku'
            ]);

            $validate = Validator::make($data, [
                'tgl_transaksi'     => 'required',
                'jenis_transaksi'   => 'required',
                'sumber_dana'       => 'required',
                'disimpan_ke'       => 'required',
                'harsat'            => 'required',
                'nama_barang'       => 'required',
                'alasan'            => 'required',
                'unit'              => 'required',
                'harga_jual'        => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
            }

            $sumber_dana = $request->sumber_dana;
            $disimpan_ke = $request->disimpan_ke;
            $nilai_buku = $request->unit * $request->harsat;
            $status = $request->alasan;

            $nama_barang = explode('#', $request->nama_barang);
            $id_inv = $nama_barang[0];
            $jumlah_barang = $nama_barang[1];

            $inv = Inventory::where('id', $id_inv)->first();

            $tgl_beli = $inv->tgl_beli;
            $harsat = $inv->harsat;
            $umur_ekonomis = $inv->umur_ekonomis;
            $sisa_unit = $jumlah_barang - $request->unit;
            $barang = $inv->nama_barang;
            $jenis = $inv->jenis;
            $kategori = $inv->kategori;

            $trx_penghapusan = [
                'tgl_transaksi'         => (string) Tanggal::tglNasional($request->tgl_transaksi),
                'rekening_debit'        => (string) $request->disimpan_ke,
                'rekening_kredit'       => (string) $request->sumber_dana,
                'usage_id'              => '0',
                'installation_id'       => '0',
                'keterangan_transaksi'  => (string) 'Penghapusan ' . $request->unit . ' unit ' . $barang . ' (' . $id_inv . ')' . ' karena ' . $status,
                'relasi'                => (string) $request->relasi,
                'total'                 => $nilai_buku,
                'urutan'                => '0',
                'user_id'               => auth()->user()->id,
            ];

            $update_inventaris = [
                'unit'          => $sisa_unit,
                'tgl_validasi'  => Tanggal::tglNasional($request->tgl_transaksi)
            ];

            $update_sts_inventaris = [
                'status'        => ucwords($status),
                'tgl_validasi'  => Tanggal::tglNasional($request->tgl_transaksi)
            ];

            $insert_inventaris = [
                'business_id'   => Session::get('business_id'),
                'nama_barang'   => $barang,
                'tgl_beli'      => $tgl_beli,
                'unit'          => $request->unit,
                'harsat'        => $harsat,
                'umur_ekonomis' => $umur_ekonomis,
                'jenis'         => $jenis,
                'kategori'      => $kategori,
                'status'        => ucwords($status),
                'tgl_validasi'  => Tanggal::tglNasional($request->tgl_transaksi),
            ];

            $trx_penjualan = [
                'tgl_transaksi'  => (string) Tanggal::tglNasional($request->tgl_transaksi),
                'rekening_debit'  => '1',
                'rekening_kredit'  => '59',
                'usage_id'          => '0',
                'installation_id'     => '0',
                'keterangan_transaksi' => (string) 'Penjualan ' . $request->unit . ' unit ' . $barang . ' (' . $id_inv . ')',
                'relasi'                => (string) $request->relasi,
                'total'                  => str_replace(',', '', str_replace('.00', '', $request->harga_jual)),
                'urutan'                  => '0',
                'user_id'                   => auth()->user()->id,
            ];

            if ($request->unit < $jumlah_barang) {
                if ($status != 'rusak') {
                    $transaksi = Transaction::create($trx_penghapusan);
                }
                Inventory::where('id', $id_inv)->update($update_inventaris);

                if ($status != 'revaluasi') {
                    Inventory::create($insert_inventaris);
                }
            } else {
                if ($status != 'rusak') {
                    $transaksi = Transaction::create($trx_penghapusan);
                }
                Inventory::where('id', $id_inv)->update($update_sts_inventaris);
            }

            if ($status == 'revaluasi') {
                $harga_jual = floatval(str_replace(',', '', str_replace('.00', '', $request->harga_jual)));

                $insert_inventaris_baru = [
                    'business_id'   => Session::get('business_id'),
                    'nama_barang'   => $barang,
                    'tgl_beli'      => Tanggal::tglNasional($request->tgl_transaksi),
                    'unit'          => $request->unit,
                    'harsat'        => $harga_jual / $request->unit,
                    'umur_ekonomis' => $umur_ekonomis,
                    'jenis'         => $jenis,
                    'kategori'      => $kategori,
                    'status'        => 'Baik',
                    'tgl_validasi'  => Tanggal::tglNasional($request->tgl_transaksi),
                ];

                if ($harga_jual != $request->_nilai_buku) {
                    $jumlah = $harga_jual - $request->_nilai_buku;
                    $trx_revaluasi = [
                        'tgl_transaksi' => (string) Tanggal::tglNasional($request->tgl_transaksi),
                        'rekening_debit' => '1',
                        'rekening_kredit' => '61',
                        'usage_id'         => '0',
                        'installation_id'   => '0',
                        'keterangan'         => (string) 'Revaluasi ' . $request->unit . ' unit ' . $barang . ' (' . $id_inv . ')',
                        'relasi'              => '',
                        'total'                => $jumlah,
                        'urutan'                => '0',
                        'user_id'                => auth()->user()->id,
                    ];

                    Transaction::create($trx_revaluasi);
                }

                Transaction::create($insert_inventaris_baru);
            }

            $msg = 'Penghapusan ' . $request->unit . ' unit ' . $barang . ' karena ' . $status;
            if ($status == 'dijual') {
                $transaksi = Transaction::create($trx_penjualan);
                $msg = 'Penjualan ' . $request->unit . ' unit ' . $barang;
            }

            if ($status == 'rusak') {
                return response()->json([
                    'success'   => true,
                    'msg'       => $msg,
                    'view'      => ''
                ]);
            }
        } else {
            if (Keuangan::startWith($disimpan_ke, '1.2.01') || Keuangan::startWith($disimpan_ke, '1.2.03')) {
                $data = $request->only([
                    'tgl_transaksi',
                    'jenis_transaksi',
                    'sumber_dana',
                    'disimpan_ke',
                    'relasi',
                    'nama_barang',
                    'jumlah',
                    'harga_satuan',
                    'umur_ekonomis',
                ]);

                $validate = Validator::make($data, [
                    'tgl_transaksi'     => 'required',
                    'jenis_transaksi'   => 'required',
                    'sumber_dana'       => 'required',
                    'disimpan_ke'       => 'required',
                    'nama_barang'       => 'required',
                    'jumlah'            => 'required',
                    'harga_satuan'      => 'required',
                    'umur_ekonomis'     => 'required'
                ]);

                if ($validate->fails()) {
                    return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
                }

                $rek_simpan = Account::where('kode_akun', $disimpan_ke)->first();

                $insert = [
                    'tgl_transaksi' => (string) Tanggal::tglNasional($request->tgl_transaksi),
                    'rekening_debit' => (string) $request->disimpan_ke,
                    'rekening_kredit' => (string) $request->sumber_dana,
                    'usage_id'         => 0,
                    'installation_id'   => 0,
                    'keterangan'         => (string) '(' . $rek_simpan->nama_akun . ') ' . $request->nama_barang,
                    'relasi'              => (string) $request->relasi,
                    'total'                => str_replace(',', '', str_replace('.00', '', $request->harga_satuan)) * $request->jumlah,
                    'urutan'                => 0,
                    'user_id'                 => auth()->user()->id,
                ];

                $inventaris = [
                    'business_id'   => Session::get('business_id'),
                    'nama_barang'   => $request->nama_barang,
                    'tgl_beli'      => Tanggal::tglNasional($request->tgl_transaksi),
                    'unit'          => $request->jumlah,
                    'harsat'        => str_replace(',', '', str_replace('.00', '', $request->harga_satuan)),
                    'umur_ekonomis' => $request->umur_ekonomis,
                    'jenis'         => str_pad($rek_simpan->lev3, 1, "0", STR_PAD_LEFT),
                    'kategori'      => str_pad($rek_simpan->lev4, 1, "0", STR_PAD_LEFT),
                    'status'        => 'Baik',
                    'tgl_validasi'  => Tanggal::tglNasional($request->tgl_transaksi),
                ];

                $transaksi = Transaction::create($insert);
                $inv = Inventory::create($inventaris);

                $msg = 'Transaksi ' .  $rek_simpan->nama_akun . ' (' . $insert['keterangan'] . ') berhasil disimpan';
            } else {
                $data = $request->only([
                    'tgl_transaksi',
                    'jenis_transaksi',
                    'sumber_dana',
                    'disimpan_ke',
                    'relasi',
                    'keterangan',
                    'nominal'
                ]);

                $validate = Validator::make($data, [
                    'tgl_transaksi'     => 'required',
                    'jenis_transaksi'   => 'required',
                    'sumber_dana'       => 'required',
                    'disimpan_ke'       => 'required',
                    'nominal'           => 'required'
                ]);

                if ($validate->fails()) {
                    return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
                }

                $relasi = '';
                if ($request->relasi) $relasi = $request->relasi;
                $insert = [
                    'tgl_transaksi'     => (string) Tanggal::tglNasional($request->tgl_transaksi),
                    'rekening_debit'    => (string) $request->disimpan_ke,
                    'rekening_kredit'   => (string) $request->sumber_dana,
                    'usage_id'          => 0,
                    'installation_id'   => 0,
                    'relasi'            => (string) $relasi,
                    'total'             => str_replace(',', '', str_replace('.00', '', $request->nominal)),
                    'keterangan'        => (string) $request->keterangan,
                    'user_id'           => auth()->user()->id,
                ];

                $transaksi = Transaction::create($insert);
                $msg = 'Transaksi ' . $insert['keterangan'] . ' berhasil disimpan';
            }
        }

        $trx = Transaction::where('id', $transaksi->id)->with([
            'rek_debit', 'rek_kredit'
        ])->first();

        $view = view('transaksi.jurnal_umum.partials.notifikasi')->with(compact('trx', 'keuangan'))->render();
        return response()->json([
            'success'   => true,
            'msg'       => $msg,
            'view'      => $view,
        ]);
    }

    /**
     * Create data Pelunasan Instalasi.
     */
    private function Createpelunasaninstalasi($request)
    {
        $data = $request->only([
            "tgl_transaksi",
            "istallation_id",
            "abodemen",
            "biaya_sudah_dibayar",
            "pembayaran",
        ]);

        $data['abodemen'] = str_replace(',', '', $data['abodemen']);
        $data['abodemen'] = str_replace('.00', '', $data['abodemen']);
        $data['abodemen'] = floatval($data['abodemen']);

        $data['biaya_sudah_dibayar'] = str_replace(',', '', $data['biaya_sudah_dibayar']);
        $data['biaya_sudah_dibayar'] = str_replace('.00', '', $data['biaya_sudah_dibayar']);
        $data['biaya_sudah_dibayar'] = floatval($data['biaya_sudah_dibayar']);

        $data['pembayaran'] = str_replace(',', '', $data['pembayaran']);
        $data['pembayaran'] = str_replace('.00', '', $data['pembayaran']);
        $data['pembayaran'] = floatval($data['pembayaran']);

        $abodemen = $data['abodemen'];
        $biaya_sudah_dibayar = $data['biaya_sudah_dibayar'] ?? null;
        $biaya_instalasi = $data['pembayaran'];

        $penjumlahantrx = $biaya_sudah_dibayar + $biaya_instalasi;
        $biaya_instal = $data['abodemen'] - $penjumlahantrx;

        // TRANSACTION TIDAK BOLEH NYICIL
        $jumlah_instal = ($biaya_instal >= 0) ? $biaya_instalasi : $biaya_sudah_dibayar;
        if (empty($biaya_sudah_dibayar)) {
            $persen = $biaya_instal * 100;
        } else {
            $persen = 100 - ($biaya_instal / $biaya_sudah_dibayar * 100);
        }
        $persen = ($penjumlahantrx / $abodemen) * 100;
        $transaksi = Transaction::create([
            'rekening_debit' => '1',
            'rekening_kredit' => '67',
            'tgl_transaksi' => Tanggal::tglNasional($request->tgl_transaksi),
            'total' => $jumlah_instal,
            'installation_id' => $request->istallation_id,
            'keterangan' => 'Biaya istalasi ' . $persen . '%',
        ]);

        if ($biaya_instal <= 0) {
            Installations::where('id', $request->transaction_id)->update([
                'status' => 'R',
            ]);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Pembayaran berhasil disimpan',
            'transaksi' => $transaksi,
            'transaction_id' => $transaksi->id
        ]);
    }

    public function struk_instalasi($id)
    {
        $keuangan = new Keuangan;

        $bisnis = Business::where('id', Session::get('business_id'))->first();
        $trx = Transaction::where('id', $id)->with([
            'Installations.customer'
        ])->first();
        $user = User::where('id', $trx->user_id)->first();
        $kode_akun = Account::where('id', $trx)->value('kode_akun');

        $jenis = 'Pembayaran Instalasi';
        $dari = ucwords($trx->Installations->customer->nama);
        $oleh = ucwords(auth()->user()->nama);

        $logo = $bisnis->logo;
        if (empty($logo)) {
            $gambar = '/storage/logo/1.png';
        } else {
            $gambar = '/storage/logo/' . $logo;
        }

        return view('transaksi.dokumen.struk_installasi')->with(compact('trx', 'keuangan', 'dari', 'oleh', 'jenis', 'bisnis', 'gambar'));
    }

    /**
     * Create data Pelunasan bulanan.
     */
    private function CreateTagihanBulanan($request)
    {
        $data = $request->only([
            "tgl_transaksi",
            "id_trx",
            "id_usage",
            "pembayaran",
            "tagihan",
            "keterangan",
        ]);

        $data['tagihan'] = str_replace(',', '', $data['tagihan']);
        $data['tagihan'] = str_replace('.00', '', $data['tagihan']);
        $data['tagihan'] = floatval($data['tagihan']);

        $data['pembayaran'] = str_replace(',', '', $data['pembayaran']);
        $data['pembayaran'] = str_replace('.00', '', $data['pembayaran']);
        $data['pembayaran'] = floatval($data['pembayaran']);

        $biaya_tagihan = $data['tagihan'];
        $biaya_instalasi = $data['pembayaran'];
        // TRANSACTION TAGIHAN BULANAN
        $transaksi = Transaction::create([
            'rekening_debit' => '1',
            'rekening_kredit' => '59',
            'tgl_transaksi' => Tanggal::tglNasional($request->tgl_transaksi),
            'total' => $biaya_instalasi,
            'installation_id' => $request->id_trx,
            'usage_id' => $request->id_usage,
            'keterangan' => $request->keterangan
        ]);

        if ($biaya_tagihan == $biaya_instalasi) {
            Usage::where('id', $request->id_usage)->update([
                'status' => 'PAID',
            ]);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Pembayaran berhasil disimpan',
            'transaksi' => $transaksi,
            'transaction_id' => $transaksi->id
        ]);
    }

    public function struk_tagihan($id)
    {
        $keuangan = new Keuangan;

        $bisnis = Business::where('id', Session::get('business_id'))->first();
        $trx = Transaction::where('id', $id)->with([
            'Installations.customer',
            'Usages'
        ])->first();
        $user = User::where('id', $trx->user_id)->first();
        $kode_akun = Account::where('id', $trx)->value('kode_akun');

        $jenis = 'Pembayaran Bulanan';
        $dari = ucwords($trx->Installations->customer->nama);
        $oleh = ucwords(auth()->user()->nama);

        $logo = $bisnis->logo;
        if (empty($logo)) {
            $gambar = '/storage/logo/1.png';
        } else {
            $gambar = '/storage/logo/' . $logo;
        }

        return view('transaksi.dokumen.struk_tagihan')->with(compact('trx', 'keuangan', 'dari', 'oleh', 'jenis', 'bisnis', 'gambar'));
    }
    /**
     * Set saldo.
     */
    public function saldo($kode_akun)
    {
        $keuangan = new Keuangan;

        $total_saldo = 0;
        if (request()->get('tahun') || request()->get('bulan') || request()->get('hari')) {
            $data = [];
            $data['tahun'] = request()->get('tahun');
            $data['bulan'] = request()->get('bulan');
            $data['hari'] = request()->get('hari');
            $data['kode_akun'] = $kode_akun;

            $thn = $data['tahun'];
            $bln = $data['bulan'];
            $hari = $data['hari'];

            $tgl = $thn . '-' . $bln . '-';
            $bulan_lalu = date('m', strtotime('-1 month', strtotime($tgl . '01')));
            $awal_bulan = $thn . '-' . $bulan_lalu . '-' . date('t', strtotime($thn . '-' . $bulan_lalu));
            if ($bln == 1) {
                $awal_bulan = $thn . '00-00';
            }

            $data['tgl_kondisi'] = $tgl;
            $kode_akun_by_id = $data['kode_akun'];
            $kode_akun = Account::where('id', $kode_akun_by_id)->value('kode_akun');

            $data['rek'] = Account::where('kode_akun', $kode_akun)->with([
                'amount' => function ($query) use ($data) {
                    $query->where('tahun', $data['tahun'])->where(function ($query) use ($data) {
                        $query->where('bulan', '0')->orwhere('bulan', $data['bulan']);
                    });
                },
            ])->first();

            $total_saldo = $keuangan->komSaldo($data['rek']);
        }

        return response()->json([
            'saldo' => $total_saldo
        ]);
    }

    /**
     * .cetakdetailTransaksi jurnal umum
     */
    public function detailTransaksi(Request $request)
    {
        $keuangan = new Keuangan;

        $kode_akun_by_id = $request->account_id;
        $data['tahun'] = $request->tahun;
        $data['bulan'] = $request->bulan;
        $data['hari'] = $request->hari;

        if ($data['tahun'] == null) {
            abort(404);
        }

        $data['bulanan'] = true;
        if ($data['bulan'] == null) {
            $data['bulanan'] = false;
            $data['bulan'] = '12';
        }

        $data['harian'] = true;
        if ($data['hari'] == null) {
            $data['harian'] = false;
            $data['hari'] = date('t', strtotime($data['tahun'] . '-' . $data['bulan'] . '-01'));
        }

        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Tahunan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);

        $awal_bulan = $thn . '00-00';
        if ($data['bulanan']) {
            $tgl = $thn . '-' . $bln . '-';
            $data['judul'] = 'Laporan Bulanan';
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $bulan_lalu = date('m', strtotime('-1 month', strtotime($tgl . '01')));
            $awal_bulan = $thn . '-' . $bulan_lalu . '-' . date('t', strtotime($thn . '-' . $bulan_lalu));
            if ($bln == 1) {
                $awal_bulan = $thn . '00-00';
            }
        }

        if ($data['harian']) {
            $tgl = $thn . '-' . $bln . '-' . $hari;
            $data['judul'] = 'Laporan Harian';
            $data['sub_judul'] = 'Tanggal ' . $hari . ' ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::tglLatin($tgl);
            $awal_bulan = date('Y-m-d', strtotime('-1 day', strtotime($tgl)));
        }

        $data['tgl_kondisi'] = $data['tahun'] . '-' . $data['bulan'] . '-' . $data['hari'];

        $data['is_dir'] = (auth()->guard('web')->user()->level == 1 && (auth()->guard('web')->user()->jabatan == 1 || auth()->guard('web')->user()->jabatan == 3)) ? true : false;
        $data['is_ben'] = (auth()->guard('web')->user()->level == 1 && (auth()->guard('web')->user()->jabatan == 3)) ? true : false;

        $data['rek'] = Account::where('id', $kode_akun_by_id)->first();
        $data['transaksi'] = Transaction::where('tgl_transaksi', 'LIKE', '%' . $tgl . '%')->where(function ($query) use ($kode_akun_by_id) {
            $query->where('rekening_debit', $kode_akun_by_id)->orwhere('rekening_kredit', $kode_akun_by_id);
        })->with([
            'user',
            'rek_debit',
            'rek_kredit'
        ])->orderBy('tgl_transaksi', 'ASC')->orderBy('urutan', 'ASC')->orderBy('id', 'ASC')->get();

        $data['keuangan'] = $keuangan;
        $data['saldo'] = $keuangan->saldoAwal($data['tgl_kondisi'], $kode_akun_by_id);
        $data['d_bulan_lalu'] = $keuangan->saldoD($awal_bulan, $kode_akun_by_id);
        $data['k_bulan_lalu'] = $keuangan->saldoK($awal_bulan, $kode_akun_by_id);

        return [
            'label' => '<i class="fas fa-book"></i> ' . $data['rek']->kode_akun . ' - ' . $data['rek']->nama_akun . ' ' . $data['sub_judul'],
            'view' => view('transaksi.jurnal_umum.partials.jurnal', $data)->render(),
            'cetak' => view('transaksi.jurnal_umum.partials._jurnal', $data)->render()
        ];
    }

    /**
     * .cetak kuitansi notifikasi jurnal umum
     */


    public function cetak(Request $request)
    {
        $keuangan = new Keuangan;
        $id = $request->cetak;

        $data['bisnis'] = Business::where('id', Session::get('business_id'))->first();
        $data['transaksi'] = Transaction::whereIn('id', $id)
            ->selectRaw('*, SUM(total) as total_sum')
            ->groupBy('id')
            ->with('rek_debit', 'rek_kredit')
            ->get();
        $data['dir'] = User::where([
            ['jabatan', '1'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $data['sekr'] = User::where([
            ['jabatan', '2'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $logo = $data['bisnis']->logo;
        $data['gambar'] = $logo;
        $data['keuangan'] = $keuangan;

        $view = view('transaksi.jurnal_umum.dokumen.cetak', $data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function kuitansi($id)
    {
        $keuangan = new Keuangan;

        $bisnis = Business::where('id', Session::get('business_id'))->first();
        $trx = Transaction::where('id', $id)->first();
        $user = User::where('id', $trx->user_id)->first();

        $kode_akun = Account::where('id', $trx)->value('kode_akun');

        $jenis = 'BKM';
        $dari = ucwords($trx->relasi);
        $oleh = ucwords(auth()->user()->nama);
        $dibayar = ucwords($trx->relasi);
        if ($trx->rekening_kredit == '1.1.01.01' or ($keuangan->startWith($trx->rekening_kredit, '1.1.02') || $keuangan->startWith($trx->rekening_kredit, '1.1.01'))) {
            $jenis = 'BKK';
            $dari = ucwords($bisnis->nama);
            $oleh = ucwords($trx->relasi);
            $dibayar = ucwords($user->nama);
        }

        $logo = $bisnis->logo;
        if (empty($logo)) {
            $gambar = '/storage/logo/1.png';
        } else {
            $gambar = '/storage/logo/' . $logo;
        }

        return view('transaksi.jurnal_umum.dokumen.kuitansi')->with(compact('trx', 'bisnis', 'jenis', 'dari', 'oleh', 'dibayar', 'gambar', 'keuangan'));
    }

    public function kuitansi_thermal($id)
    {
        $kertas = '80';
        if (request()->get('kertas')) {
            $kertas = request()->get('kertas');
        }

        $keuangan = new Keuangan;

        $business = Business::where('id', Session::get('business_id'))->first();
        $trx = Transaction::where('id', $id)->first();
        $user = User::where('id', $trx->user_id)->first();

        $jenis = 'BKM';
        $dari = ucwords($trx->relasi);
        $oleh = ucwords(auth()->user()->nama);
        $dibayar = ucwords($trx->relasi);
        if ($trx->rekening_kredit == '1.1.01.01' or ($keuangan->startWith($trx->rekening_kredit, '1.1.02') || $keuangan->startWith($trx->rekening_kredit, '1.1.01'))) {
            $jenis = 'BKK';
            $dari = ucwords($business->nama);
            $oleh = ucwords($trx->relasi);
            $dibayar = ucwords($user->nama);
        }

        $logo = $business->logo;
        if (empty($logo)) {
            $gambar = '/storage/logo/1.png';
        } else {
            $gambar = '/storage/logo/' . $logo;
        }

        return view('transaksi.jurnal_umum.dokumen.kuitansi_thermal')->with(compact('trx', 'business', 'jenis', 'dari', 'oleh', 'dibayar', 'gambar', 'keuangan', 'kertas'));
    }

    public function bkk($id)
    {
        $keuangan = new Keuangan;

        $business = Business::where('id', Session::get('business_id'))->first();
        $trx = Transaction::where('id', $id)->with('rek_debit')->with('rek_kredit')->first();

        $user = User::where('id', $trx->user_id)->first();

        $dir = User::where([
            ['jabatan', '1'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $sekr = User::where([
            ['jabatan', '2'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $logo = $business->logo;
        $gambar = '/storage/logo/' . $logo;

        return view('transaksi.jurnal_umum.dokumen.bkk')->with(compact('trx', 'business', 'dir', 'sekr', 'gambar', 'keuangan'));
    }

    public function bkm($id)
    {
        $keuangan = new Keuangan;

        $business = Business::where('id', Session::get('business_id'))->first();
        $trx = Transaction::where('id', $id)->with('rek_debit')->with('rek_kredit')->first();
        $user = User::where('id', $trx->id_user)->first();
        $dir = User::where([
            ['jabatan', '1'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $sekr = User::where([
            ['jabatan', '2'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $logo = $business->logo;
        $gambar = '/storage/logo/' . $logo;

        return view('transaksi.jurnal_umum.dokumen.bkm')->with(compact('trx', 'business', 'dir', 'sekr', 'gambar', 'keuangan'));
    }

    public function bm($id)
    {
        $keuangan = new Keuangan;

        $business = Business::where('id', Session::get('business_id'))->first();
        $trx = Transaction::where('id', $id)->with('rek_debit')->with('rek_kredit')->first();
        $user = User::where('id', $trx->user_id)->first();

        $dir = User::where([
            ['jabatan', '1'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $sekr = User::where([
            ['jabatan', '2'],
            ['business_id', Session::get('business_id')]
        ])->first();

        $logo = $business->logo;
        $gambar = '/storage/logo/' . $logo;

        return view('transaksi.jurnal_umum.dokumen.bm')->with(compact('trx', 'business', 'dir', 'sekr', 'gambar', 'keuangan'));
    }

    public function data($id)
    {
        $trx = Transaction::where('id', $id)->first();
        return response()->json([
            'id' => $trx->id,
            'installation_id' => $trx->installation_id,
            'total' => number_format($trx->total)
        ]);
    }

    public function reversal(Request $request)
    {
        $id = $request->rev_id;
        $install = $request->rev_istal_id;

        $bulan = 0;
        $tahun = 0;
        $kode_akun = [];

        $trx = Transaction::where('id', $id)->first();

        $tgl = explode('-', $trx->tgl_transaksi);
        $tahun = $tgl[0];
        $bulan = $tgl[1];

        $kode_akun[$trx->rekening_debit] = $trx->rekening_debit;
        $kode_akun[$trx->rekening_kredit] = $trx->rekening_kredit;

        $reversal = Transaction::create([
            'tgl_transaksi' => (string) date('Y-m-d'),
            'rekening_debit' => (string) $trx->rekening_debit,
            'rekening_kredit' => (string) $trx->rekening_kredit,
            'usage_id' => $trx->usage_id,
            'installation_id' => $trx->installation_id,
            'keterangan' => (string) 'KOREKSI idt (' . $id . ') : ' . $trx->keterangan,
            'relasi' => (string) $trx->relasi,
            'total' => ($trx->total * -1),
            'urutan' => $trx->urutan,
            'id_user' => auth()->user()->id
        ]);


        return response()->json([
            'success' => true,
            'msg' => 'Transaksi Reversal untuk id ' . $id . ' dengan nominal berhasil.',
            'tgl_transaksi' => date('Y-m-d'),
            'id_Transaksi' => $install,
            'kode_akun' => implode(',', $kode_akun),
            'bulan' => str_pad($bulan, 2, "0", STR_PAD_LEFT),
            'tahun' => $tahun
        ]);
    }

    public function hapus(Request $request)
    {
        $id = $request->del_id;
        $installation_id = $request->del_instal_id;

        if ($installation_id != '0') {
            $instal = Installations::where('id', $installation_id)->update([
                'status' => 'I'
            ]);
        }

        $rek_inventaris = ['1.2.01.01', '1.2.01.02', '1.2.01.03', '1.2.01.04', '1.2.03.01', '1.2.03.02', '1.2.03.03', '1.2.03.04'];

        $trx = Transaction::where('id', $id)->first();
        if (in_array($trx->rekening_debit, $rek_inventaris)) {
            $jenis = intval(explode('.', $trx->rekening_debit)[2]);
            $kategori = intval(explode('.', $trx->rekening_debit)[3]);
            $nama_barang = trim(explode(')', $trx->keterangan_transaksi)[1]);

            $inv = Inventory::Where([
                ['jenis', $jenis],
                ['kategori', $kategori],
                ['tgl_beli', $trx->tgl_transaksi],
                ['nama_barang', $nama_barang]
            ])->delete();
        }

        $transaksi = Transaction::where('id', $id)->get();
        $trx = Transaction::where('id', $id)->delete();


        $bulan = 0;
        $tahun = 0;
        $kode_akun = [];
        foreach ($transaksi as $trx) {
            $tgl = explode('-', $trx->tgl_transaksi);
            $tahun = $tgl[0];
            $bulan = $tgl[1];

            $kode_akun[$trx->rekening_debit] = $trx->rekening_debit;
            $kode_akun[$trx->rekening_kredit] = $trx->rekening_kredit;
        }
        $kode_akun = array_values($kode_akun);

        return response()->json([
            'success' => true,
            'msg' => 'Transaksi Berhasil Dihapus.',
            'kode_akun' => implode(',', $kode_akun),
            'bulan' => str_pad($bulan, 2, "0", STR_PAD_LEFT),
            'tahun' => $tahun
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
