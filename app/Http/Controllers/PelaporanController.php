<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Usage;
use App\Models\AkunLevel1;
use App\Models\Amount;
use App\Models\Business;
use App\Models\Calk;
use App\Models\Village;
use App\Models\Installations;
use App\Models\Inventory;
use App\Models\JenisLaporan;
use App\Models\JenisLaporanPinjaman;
use App\Models\MasterArusKas;
use App\Models\Transaction;
use App\Models\User;
use App\Utils\Keuangan;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PelaporanController extends Controller
{

    public function index()
    {
        $busines = Business::where('id', Session::get('business_id'))->first();
        $laporan = JenisLaporan::where([['file', '!=', '0']])->orderBy('urut', 'ASC')->get();

        $title = 'Pelaporan';
        return view('pelaporan.index')->with(compact('title', 'laporan', 'busines'));
    }
    public function subLaporan($file)
    {
        $sub_laporan = [
            0 => [
                'value' => '',
                'title' => 'Pilih Sub Laporan'
            ]
        ];

        if ($file == 'buku_besar') {
            $accounts = Account::where('business_id', Session::get('business_id'))->get();
            foreach ($accounts as $acc) {
                $sub_laporan[] = [
                    'value' => $acc->kode_akun,
                    'title' => $acc->kode_akun . '. ' . $acc->nama_akun
                ];
            }
        }

        if ($file == 'e_budgeting') {
            $sub_laporan = [
                0 => [
                    'title' => 'Pilih Sub Laporan',
                    'value' => ''
                ],
                1 => [
                    'title' => '01. Januari - Maret',
                    'value' => '1,2,3'
                ],
                2 => [
                    'title' => '02. April - Juni',
                    'value' => '4,5,6'
                ],
                3 => [
                    'title' => '03. Juli - September',
                    'value' => '7,8,9'
                ],
                4 => [
                    'title' => '04. Oktober - Desember',
                    'value' => '10,11,12'
                ]
            ];
        }

        if ($file == 'piutang_pelanggan') {
            $laporan_pinj = JenisLaporanPinjaman::all();
            foreach ($laporan_pinj as $lp) {
                $sub_laporan[] = [
                    'value' => $lp->file,
                    'title' => $lp->nama_laporan
                ];
            }
        }

        if ($file == 'tutup_buku') {
            $sub_laporan = [
                0 => [
                    'title' => 'Pengalokasian Laba',
                    'value' => 'alokasi_laba'
                ],
                1 => [
                    'title' => 'Jurnal Tutup Buku',
                    'value' => 'jurnal_tutup_buku'
                ],
                2 => [
                    'title' => 'Neraca',
                    'value' => 'neraca_tutup_buku'
                ],
                3 => [
                    'title' => 'Laba Rugi',
                    'value' => 'laba_rugi_tutup_buku'
                ],
                4 => [
                    'title' => 'CALK',
                    'value' => 'CALK_tutup_buku'
                ]
            ];
        }
        if ($file == 'calk') {
            $tahun = request()->get('tahun');
            $bulan = request()->get('bulan');

            $calk = Calk::where([
                ['tanggal', 'LIKE', $tahun . '-' . $bulan . '%']
            ])->first();

            $keterangan = '';
            if ($calk) {
                $keterangan = $calk->catatan;
            }
        }

        return view('pelaporan.partials.sub_laporan')->with(compact('sub_laporan'));
    }

    public function preview(Request $request, $business_id = null)
    {
        $data = $request->only([
            'tahun',
            'bulan',
            'hari',
            'laporan',
            'sub_laporan',
            'type'
        ]);


        $busines = Business::where('id', Session::get('business_id'))->first();
        $direktur = User::where([
            ['jabatan','1'],
            ['business_id', Session::get('business_id')]
        ])->with(['position'])->first();

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

        $data['tgl_kondisi'] = $data['tahun'] . '-' . $data['bulan'] . '-' . $data['hari'];
        $laporan = $request->laporan;
        if ($laporan == 'tutup_buku') {
            $laporan = $request->sub_laporan;
        }
        $data['logo'] = $busines->logo;

        $data['nomor_usaha'] = 'SK Kemenkumham RI No.' . $busines->nomor_bh;
        $data['info'] = $busines->alamat . ', Telp.' . $busines->telpon;
        $data['email'] = $busines->email;
        $data['nama'] = $busines->nama;
        $data['alamat'] = $busines->alamat;
        $data['jabatan'] = $direktur->positions;
        $data['direktur'] = $direktur;

        return $this->$laporan($data);
    }

    private function cover(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['title'] = 'Cover';
        $view = view('pelaporan.partials.views.cover', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function calkk(array $data)
    {
        $keuangan = new Keuangan;
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['akun1'] = AkunLevel1::where('lev1', '<=', '3')->with([
            'akun2',
            'akun2.akun3',
            'akun2.akun3.accounts' => function ($query) {
                $query->where('business_id', Session::get('business_id'));
            },
            'akun2.akun3.accounts.amount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where(function ($query) use ($data) {
                    $query->where('bulan', '0')->orwhere('bulan', $data['bulan']);
                });
            },
        ])->orderBy('kode_akun', 'ASC')->get();

        $laba_rugi = Account::where('business_id', Session::get('business_id'))->where('lev1', '>=', '4')->with([
            'amount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where(function ($query) use ($data) {
                    $query->where('bulan', '0')->orwhere('bulan', $data['bulan']);
                });
            },
        ])->get();

        $pendapatan = 0;
        $beban = 0;
        foreach ($laba_rugi as $lr) {
            $saldo = $keuangan->komSaldo($lr);
            if ($lr->lev1 == '4') {
                $pendapatan += $saldo;
            }

            if ($lr->lev1 == '5') {
                $beban += $saldo;
            }
        }

        $data['surplus'] = $pendapatan - $beban;

        $data['title'] = 'Calk';
        $view = view('pelaporan.partials.views.calk', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function surat_pengantar(array $data)
    {
        $villages = Village::where('id', Session::get('business_id'))->first();

        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        if (strlen($hari) > 0 && strlen($bln) > 0) {
            $tgl = $thn . '-' . $bln . '-' . $hari;
            $data['judul'] = 'Laporan Harian';
            $data['sub_judul'] = 'Tanggal ' . Tanggal::tglLatin($tgl);
            $data['tgl'] = Tanggal::tglLatin($tgl);
        } elseif (strlen($bln) > 0) {
            $tgl = $thn . '-' . $bln . '-' . $hari;
            $data['judul'] = 'Laporan Bulanan';
            $data['sub_judul'] = 'Tanggal ' . Tanggal::tglLatin(date('Y-m-t', strtotime($thn . '-' . $bln . '-01')));
            $data['tgl'] = Tanggal::tglLatin(date('Y-m-t', strtotime($thn . '-' . $bln . '-01')));
        } else {
            $tgl = $thn . '-' . $bln . '-' . $hari;
            $data['judul'] = 'Laporan Tahunan';
            $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::tahun($tgl);
        }
        $data['nama_desa'] = $villages->nama;
        $data['alamat_desa'] = $villages->alamat;
        $data['title'] = 'Surat Pengantar';
        $view = view('pelaporan.partials.views.surat_pengantar', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function jurnal_transaksi(array $data)
    {

        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }

        // SELECT * FROM transactions WHERE tgl_transaksi LIKE '2025-01%';
        $data['transactions'] = Transaction::where('tgl_transaksi', 'LIKE', $data['tahun'] . '-' . $data['bulan'] . '%')
            ->with([
                'acc_debit',
                'acc_kredit',
            ])->get();

        $data['title'] = 'Jurnal Transaksi';
        $view = view('pelaporan.partials.views.jurnal_transaksi', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function jurnal_tutup_buku(array $data)
    {

        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }

        // SELECT * FROM transactions WHERE tgl_transaksi LIKE '2025-01%';
        $data['transactions'] = Transaction::where('tgl_transaksi', 'LIKE', $data['tahun'] . '-' . $data['bulan'] . '%')
            ->with([
                'acc_debit',
                'acc_kredit',
            ])->get();

        $data['title'] = 'Jurnal Tutup Buku';
        $view = view('pelaporan.partials.views.tutup_buku.jurnal', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function daftar_pelanggan(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['installations'] = Installations::where('aktif', '<=', $data['tgl_kondisi'])->with([
            'customer',
            'usage' => function ($query) use ($data) {
                $query->where('tgl_akhir', '<=', $data['tgl_kondisi']);
            },
        ])->get();
        $data['title'] = 'Daftar pelanggan';
        $view = view('pelaporan.partials.views.daftar_pelanggan', $data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    private function tagihan_pelanggan(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['usages'] = Usage::with([
            'customers',
            'customers.village',
            'installation',
            'transaction',
        ])->where([
            ['tgl_akhir', '<=', $data['tgl_kondisi']],
            ['status', 'UNPAID']
        ])->get();

        $data['title'] = 'Daftar Tagihan Pelanggan';
        $view = view('pelaporan.partials.views.tagihan_pelanggan', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function piutang_pelanggan(array $data)
    {

        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }

        $data['installations'] = Installations::where('aktif', '<=', $data['tgl_kondisi'])->with([
            'customer',
            'usage' => function ($query) use ($data) {
                $query->where('tgl_akhir', '<=', $data['tgl_kondisi']);
            },
            'usage.transaction' => function ($query) use ($data) {
                $query->where('tgl_transaksi', '<=', $data['tgl_kondisi']);
            },
        ])->get();

        $data['title'] = 'Daftar Piutang Pelanggan';
        $view = view('pelaporan.partials.views.piutang_pelanggan', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function alokasi_laba_tutup_buku(array $data)
    {

        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['accounts'] = Account::where('business_id', Session::get('business_id'))->where('kode_akun', 'like', '2.1.04%')->with([
            'amount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun']);
            }
        ])->get();

        $data['title'] = 'Alokasi Laba';
        $view = view('pelaporan.partials.views.tutup_buku.alokasi_laba', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function buku_besar(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['title'] = 'Buku Besar';
        $data['kode_akun'] = $data['sub_laporan'];

        $data['account'] = Account::where([
            ['business_id', Session::get('business_id')],
            ['kode_akun', $data['kode_akun']]
        ])->first();

        $data['saldo_awal_tahun'] = Amount::where([
            ['tahun', $data['tahun']],
            ['bulan', '0'],
            ['account_id', $data['account']->id]
        ])->first();

        $data['saldo_bulan_lalu'] = Amount::where([
            ['tahun', $data['tahun']],
            ['bulan', $data['bulan'] - 1],
            ['account_id', $data['account']->id]
        ])->first();

        $data['transactions'] = Transaction::where('tgl_transaksi','LIKE',$thn . '-' . $bln . '%')->where(function($query) use($data) {
            $query->where('rekening_debit', $data['account']->id)->orwhere('rekening_kredit', $data['account']->id);
        })->get();

        $view = view('pelaporan.partials.views.buku_besar', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function neraca_saldo(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $tanggal = Tanggal::tglLatin($tgl);
            $data['sub_judul'] = 'PER ' . $tanggal;  
        }
            $tanggal = Tanggal::tglLatin($tgl);
            $data['sub_judul'] = 'PER ' . $tanggal;     
        // SELECT * FROM account WHERE business_id = Session::get('business_id');
        $data['accounts'] = Account::where('business_id', Session::get('business_id'))->with([
            'amount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where(function ($query) use ($data) {
                    $query->where('bulan', '0')->orWhere('bulan', $data['bulan']);
                });
            }
        ])->get();
        $data['title'] = 'Neraca Saldo';
        $view = view('pelaporan.partials.views.neraca_saldo', $data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    private function neraca(array $data)
    {
        $keuangan = new Keuangan;
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $tanggal = Tanggal::tglLatin($tgl);
            $data['sub_judul'] = 'PER ' . $tanggal;  
        }
        $data['akun1'] = AkunLevel1::where('lev1', '<=', '3')->with([
            'akun2',
            'akun2.akun3',
            'akun2.akun3.accounts' => function ($query) {
                $query->where('business_id', Session::get('business_id'));
            },
            'akun2.akun3.accounts.amount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where(function ($query) use ($data) {
                    $query->where('bulan', '0')->orwhere('bulan', $data['bulan']);
                });
            },
        ])->orderBy('kode_akun', 'ASC')->get();

        $laba_rugi = Account::where('business_id', Session::get('business_id'))->where('lev1', '>=', '4')->with([
            'amount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where(function ($query) use ($data) {
                    $query->where('bulan', '0')->orwhere('bulan', $data['bulan']);
                });
            },
        ])->get();

        $pendapatan = 0;
        $beban = 0;
        foreach ($laba_rugi as $lr) {
            $saldo = $keuangan->komSaldo($lr);
            if ($lr->lev1 == '4') {
                $pendapatan += $saldo;
            }

            if ($lr->lev1 == '5') {
                $beban += $saldo;
            }
        }

        $data['surplus'] = $pendapatan - $beban;

        $data['title'] = 'Neraca';
        $view = view('pelaporan.partials.views.neraca', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function neraca_tutup_buku(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['akun1'] = AkunLevel1::where('lev1', '<=', '3')->with([
            'akun2',
            'akun2.akun3',
            'akun2.akun3.accounts',
            'akun2.akun3.accounts.amount' => function ($query) use ($data) {
                $query->where([
                    ['tahun', $data['tahun']],
                    ['bulan', '0']
                ]);
            },
        ])->orderBy('kode_akun', 'ASC')->get();

        $data['title'] = 'Neraca Awal Tahun';
        $view = view('pelaporan.partials.views.tutup_buku.neraca', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function laba_rugi(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        // Mendapatkan bulan dan tahun sekarang
        $bulanSekarang = $bln;

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);

        if ($data['bulanan']) {
            $awal_tahun = Tanggal::tglLatin(date('Y-m-d', strtotime($thn . '-01-01')));
            $tanggal = Tanggal::tglLatin($tgl);

            $data['sub_judul'] = 'PERIODE ' . $awal_tahun . ' s.d. ' . $tanggal;
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }

        // Query untuk Pendapatan s.d. Bulan Lalu dan Bulan Ini
        $data['pendapatan'] = Account::where([
            ['kode_akun', 'LIKE', '4.1.%'],
            ['business_id', Session::get('business_id')]
        ])->with([
            'amount' => function ($query) use ($thn, $bulanSekarang) {
                $query->where('tahun', $thn)->where(function ($query) use ($bulanSekarang) {
                    // Data untuk Bulan Lalu (bulan aktif - 1)
                    $query->where('bulan', '0')->orWhere('bulan', '=', $bulanSekarang);
                });
            },
            'oneAmount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where('bulan', $data['bulan'] - 1);
            }
        ])->orderBy('kode_akun', 'ASC')->get();

        $data['beban'] = Account::where([
            ['kode_akun', 'LIKE', '5.1.%'],
            ['business_id', Session::get('business_id')]
        ])->orWhere('kode_akun', 'LIKE', '5.2.%')
            ->where('kode_akun', '!=', '5.2.01.01')
            ->with([
                'amount' => function ($query) use ($thn, $bulanSekarang) {
                    $query->where('tahun', $thn)->where(function ($query) use ($bulanSekarang) {
                        // Data untuk Bulan Lalu (bulan aktif - 1)
                        $query->where('bulan', '0')->orWhere('bulan', '=', $bulanSekarang);
                    });
                },
                'oneAmount' => function ($query) use ($data) {
                    $query->where('tahun', $data['tahun'])->where('bulan', $data['bulan'] - 1);
                }
            ])->orderBy('kode_akun', 'ASC')->get();

        $data['pen'] = Account::where([
            ['kode_akun', 'LIKE', '4.2.%'],
            ['business_id', Session::get('business_id')]
        ])->orWhere('kode_akun', 'LIKE', '4.3.%')
            ->whereNotIn('kode_akun', ['4.3.01.01', '4.3.01.02', '4.3.01.03'])
            ->with([
                'amount' => function ($query) use ($thn, $bulanSekarang) {
                    $query->where('tahun', $thn)->where(function ($query) use ($bulanSekarang) {
                        // Data untuk Bulan Lalu (bulan aktif - 1)
                        $query->where('bulan', '0')->orWhere('bulan', '=', $bulanSekarang);
                    });
                },
                'oneAmount' => function ($query) use ($data) {
                    $query->where('tahun', $data['tahun'])->where('bulan', $data['bulan'] - 1);
                }
            ])->orderBy('kode_akun', 'ASC')->get();

        $data['beb'] = Account::where([
            ['kode_akun', 'LIKE', '5.3.%'],
            ['business_id', Session::get('business_id')]
        ])
            ->orWhere('kode_akun', 'LIKE', '5.4%')
            ->where('kode_akun', '!=', '5.4.01.01') // Mengecualikan kode akun 5.4.01.01
            ->with([
                'amount' => function ($query) use ($thn, $bulanSekarang) {
                    $query->where('tahun', $thn)->where(function ($query) use ($bulanSekarang) {
                        // Data untuk Bulan Lalu (bulan aktif - 1)
                        $query->where('bulan', '0')->orWhere('bulan', '=', $bulanSekarang);
                    });
                },
                'oneAmount' => function ($query) use ($data) {
                    $query->where('tahun', $data['tahun'])->where('bulan', $data['bulan'] - 1);
                }
            ])->orderBy('kode_akun', 'ASC')->get();

        $data['ph'] = Account::where([['kode_akun', '5.4.01.01'], ['business_id', Session::get('business_id')]])->with([
            'amount' => function ($query) use ($thn, $bulanSekarang) {
                $query->where('tahun', $thn)->where(function ($query) use ($bulanSekarang) {
                    // Data untuk Bulan Lalu (bulan aktif - 1)
                    $query->where('bulan', '0')->orWhere('bulan', '=', $bulanSekarang);
                });
            },
            'oneAmount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where('bulan', $data['bulan'] - 1);
            }
        ])->orderBy('kode_akun', 'ASC')->get();

        $data['bp'] = Account::where([['kode_akun', '5.2.01.01'], ['business_id', Session::get('business_id')]])->with([
            'amount' => function ($query) use ($thn, $bulanSekarang) {
                $query->where('tahun', $thn)->where(function ($query) use ($bulanSekarang) {
                    // Data untuk Bulan Lalu (bulan aktif - 1)
                    $query->where('bulan', '0')->orWhere('bulan', '=', $bulanSekarang);
                });
            },
            'oneAmount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where('bulan', $data['bulan'] - 1);
            }
        ])->orderBy('kode_akun', 'ASC')->get();

        $data['pendl'] = Account::whereIn('kode_akun', ['4.3.01.01', '4.3.01.02', '4.3.01.03'])->where([
            ['business_id', Session::get('business_id')]
        ])->with([
            'amount' => function ($query) use ($thn, $bulanSekarang) {
                $query->where('tahun', $thn)->where(function ($query) use ($bulanSekarang) {
                    // Data untuk Bulan Lalu (bulan aktif - 1)
                    $query->where('bulan', '0')->orWhere('bulan', '=', $bulanSekarang);
                });
            },
            'oneAmount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where('bulan', $data['bulan'] - 1);
            }
        ])->orderBy('kode_akun', 'ASC')->get();

        $data['title'] = 'Laba Rugi';
        $view = view('pelaporan.partials.views.laba_rugi', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function laba_rugi_tutup_buku(array $data)
    {
        $thn = $data['tahun'];

        // Menyiapkan data awal tahun
        $data['judul'] = 'Laporan Keuangan';
        $data['tgl'] = 'Awal Tahun ' . $thn;

        // Query Pendapatan awal tahun
        $dataPendapatan = Account::where('business_id', Session::get('business_id'))->where('kode_akun', 'LIKE', '4.1.%')
            ->with([
                'amount' => function ($query) use ($data) {
                    $query->where([
                        ['tahun', $data['tahun']],
                        ['bulan', '0']
                    ]);
                },
                'oneAmount' => function ($query) use ($data) {
                    $query->where([
                        ['tahun', $data['tahun']],
                        ['bulan', '0']
                    ]);
                }
            ])->orderBy('kode_akun', 'ASC')->get();

        // Query Beban awal tahun
        $dataBeban = Account::where('business_id', Session::get('business_id'))->where('kode_akun', 'LIKE', '5.1.%')
            ->orWhere('kode_akun', 'LIKE', '5.2.%')
            ->where('kode_akun', '!=', '5.2.01.01')
            ->with([
                'amount' => function ($query) use ($data) {
                    $query->where([
                        ['tahun', $data['tahun']],
                        ['bulan', '0']
                    ]);
                },
                'oneAmount' => function ($query) use ($data) {
                    $query->where([
                        ['tahun', $data['tahun']],
                        ['bulan', '0']
                    ]);
                }
            ])->orderBy('kode_akun', 'ASC')->get();

        // Query Pen awal tahun
        $dataPen = Account::where('business_id', Session::get('business_id'))->where('kode_akun', 'LIKE', '4.2.%')
            ->orWhere('kode_akun', 'LIKE', '4.3.%')
            ->whereNotIn('kode_akun', ['4.3.01.01', '4.3.01.02', '4.3.01.03'])
            ->with([
                'amount' => function ($query) use ($data) {
                    $query->where([
                        ['tahun', $data['tahun']],
                        ['bulan', '0']
                    ]);
                },
                'oneAmount' => function ($query) use ($data) {
                    $query->where([
                        ['tahun', $data['tahun']],
                        ['bulan', '0']
                    ]);
                }
            ])->orderBy('kode_akun', 'ASC')->get();

        // Query Beb awal tahun
        $dataBeb = Account::where('kode_akun', 'LIKE', '5.3.%')
            ->orWhere('kode_akun', 'LIKE', '5.4.%')
            ->where('kode_akun', '!=', '5.4.01.01')
            ->with([
                'amount' => function ($query) use ($data) {
                    $query->where([
                        ['tahun', $data['tahun']],
                        ['bulan', '0']
                    ]);
                },
                'oneAmount' => function ($query) use ($data) {
                    $query->where([
                        ['tahun', $data['tahun']],
                        ['bulan', '0']
                    ]);
                }
            ])->orderBy('kode_akun', 'ASC')->get();

        // Query PPh awal tahun
        $pph = Account::where('kode_akun', '5.4.01.01')->with([
            'amount' => function ($query) use ($data) {
                $query->where([
                    ['tahun', $data['tahun']],
                    ['bulan', '0']
                ]);
            },
            'oneAmount' => function ($query) use ($data) {
                $query->where([
                    ['tahun', $data['tahun']],
                    ['bulan', '0']
                ]);
            }
        ])->orderBy('kode_akun', 'ASC')->get();

        // Query Beban Pemasaran awal tahun
        $bebanPemasaran = Account::where('business_id', Session::get('business_id'))->where('kode_akun', '5.2.01.01')->with([
            'amount' => function ($query) use ($data) {
                $query->where([
                    ['tahun', $data['tahun']],
                    ['bulan', '0']
                ]);
            },
            'oneAmount' => function ($query) use ($data) {
                $query->where([
                    ['tahun', $data['tahun']],
                    ['bulan', '0']
                ]);
            }
        ])->orderBy('kode_akun', 'ASC')->get();

        // Query Pendapatan Luar awal tahun
        $pendluar = Account::where('business_id', Session::get('business_id'))->whereIn('kode_akun', ['4.3.01.01', '4.3.01.02', '4.3.01.03'])->with([
            'amount' => function ($query) use ($data) {
                $query->where([
                    ['tahun', $data['tahun']],
                    ['bulan', '0']
                ]);
            },
            'oneAmount' => function ($query) use ($data) {
                $query->where([
                    ['tahun', $data['tahun']],
                    ['bulan', '0']
                ]);
            }
        ])->orderBy('kode_akun', 'ASC')->get();

        // Menyiapkan data untuk view
        $data = [
            'pendapatan' => $dataPendapatan,
            'beban' => $dataBeban,
            'pen' => $dataPen,
            'beb' => $dataBeb,
            'ph' => $pph,
            'bp' => $bebanPemasaran,
            'pendl' => $pendluar
        ];
        $data['sub_judul'] = 'Awal Tahun ' . $thn;
        $data['title'] = 'Laba Rugi Awal Tahun';

        // Menampilkan view dengan data yang sudah dihitung
        $view = view('pelaporan.partials.views.tutup_buku.laba_rugi', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function arus_kas(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }

        $data['akun_kas'] = Account::where('business_id', Session::get('business_id'))->where(function ($query) {
            $query->where('kode_akun', 'like', '1.1.01%')->orWhere('kode_akun', 'like', '1.1.02%');
        })->pluck('id');

        $data['tgl_awal'] = $thn . '-' . $bln . '-01';
        $data['arus_kas'] = MasterArusKas::where('parent_id', '0')->with([
            'child',
            'child.rek_debit',
            'child.rek_debit.accounts',
            'child.rek_debit.accounts.rek_debit' => function ($query) use ($data) {
                $query->whereBetween('tgl_transaksi', [$data['tgl_awal'], $data['tgl_kondisi']])->where(function ($query) use ($data) {
                    $query->whereIn('rekening_kredit', $data['akun_kas']);
                });
            },
            'child.rek_kredit',
            'child.rek_kredit.accounts.rek_kredit' => function ($query) use ($data) {
                $query->whereBetween('tgl_transaksi', [$data['tgl_awal'], $data['tgl_kondisi']])->where(function ($query) use ($data) {
                    $query->whereIn('rekening_debit', $data['akun_kas']);
                });
            },
        ])->get();

        $data['title'] = 'Arus Kas';
        $view = view('pelaporan.partials.views.arus_kas', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function LPM(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['accounts'] = Account::where('lev1', '3')->with([
            'amount' => function ($query) use ($data) {
                $query->where('tahun', $data['tahun'])->where(function ($query) use ($data) {
                    $query->where('bulan', '0')->orWhere('bulan', $data['bulan']);
                });
            }
        ])->get();

        $data['title'] = 'Laporan Perubahan Modal';
        $view = view('pelaporan.partials.views.laporan_perubahan_modal', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function ati(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['accounts'] = Account::where([
            ['kode_akun', 'LIKE', '1.2.01%'],
            ['business_id', Session::get('business_id')]
        ])->with([
            'inventory' => function ($query) use ($data) {
                $query->where([
                    ['business_id', Session::get('business_id')],
                    ['tgl_beli', '<=', $data['tgl_kondisi']]
                ])->orderBy('kategori', 'ASC')->orderBy('tgl_beli', 'ASC');
            }
        ])->get();
        $data['title'] = 'Aset Tetap Dan Inventaris';
        $view = view('pelaporan.partials.views.aset_tetap', $data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    private function atb(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }

        $data['accounts'] = Account::where([
            ['kode_akun', 'LIKE', '1.2.03%'],
            ['business_id', Session::get('business_id')]
        ])->with([
            'inventory' => function ($query) use ($data) {
                $query->where([
                    ['business_id', Session::get('business_id')],
                    ['tgl_beli', '<=', $data['tgl_kondisi']]
                ])->orderBy('kategori', 'ASC')->orderBy('tgl_beli', 'ASC');
            }
        ])->get();

        // $data['PendirianOrganisasi'] = Inventory::where([
        //     ['jenis', '3'],
        //     ['kategori', '1'],
        //     ['business_id', Session::get('business_id')],
        //     ['tgl_beli', '<=', $data['tgl_kondisi']]
        // ])->orderBy('kategori', 'ASC')->orderBy('tgl_beli', 'ASC')->get();

        // $data['Lisensi'] = Inventory::where([
        //     ['jenis', '3'],
        //     ['kategori', '2'],
        //     ['business_id', Session::get('business_id')],
        //     ['tgl_beli', '<=', $data['tgl_kondisi']]
        // ])->orderBy('kategori', 'ASC')->orderBy('tgl_beli', 'ASC')->get();

        // $data['Sewa'] = Inventory::where([
        //     ['jenis', '3'],
        //     ['kategori', '3'],
        //     ['business_id', Session::get('business_id')],
        //     ['tgl_beli', '<=', $data['tgl_kondisi']]
        // ])->orderBy('kategori', 'ASC')->orderBy('tgl_beli', 'ASC')->get();

        // $data['Asuransi'] = Inventory::where([
        //     ['jenis', '3'],
        //     ['kategori', '4'],
        //     ['business_id', Session::get('business_id')],
        //     ['tgl_beli', '<=', $data['tgl_kondisi']]
        // ])->orderBy('kategori', 'ASC')->orderBy('tgl_beli', 'ASC')->get();

        $data['title'] = 'Aset Tak Berwujud';
        $view = view('pelaporan.partials.views.aset_tak_berwujud', $data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    private function e_budgeting(array $data)
    {
        $thn = $data['tahun'];
        $bln = $data['bulan'];
        $hari = $data['hari'];

        $tgl = $thn . '-' . $bln . '-' . $hari;
        $data['judul'] = 'Laporan Keuangan';
        $data['sub_judul'] = 'Tahun ' . Tanggal::tahun($tgl);
        $data['tgl'] = Tanggal::tahun($tgl);
        if ($data['bulanan']) {
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
        $data['title'] = 'E - Budgeting';
        $view = view('pelaporan.partials.views.e_budgeting', $data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
}
