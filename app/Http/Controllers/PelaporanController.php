<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Business;
use App\Models\Calk;
use App\Models\JenisLaporan;
use App\Models\JenisLaporanPinjaman;
use App\Models\User;
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
        return view('pelaporan.index')->with(compact('title', 'laporan','busines'));
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
            $accounts = Account::all();
            foreach ($accounts as $acc) {
                $sub_laporan[] = [
                    'value' => $acc->kode_akun,
                    'title' => $acc->kode_akun .'. ' . $acc->nama_akun
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
    private function surat_pengantar(array $data)
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
        $data['title'] = 'Jurnal Transaksi';
        $view = view('pelaporan.partials.views.jurnal_transaksi', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function buku_besar(array $data)
    {
        $data['title'] = 'Buku Besar';
        $data['kode_akun'] = $data['sub_laporan'];
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
            $data['sub_judul'] = 'Bulan ' . Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
            $data['tgl'] = Tanggal::namaBulan($tgl) . ' ' . Tanggal::tahun($tgl);
        }
       $data['title'] = 'Neraca Saldo';
       $view = view('pelaporan.partials.views.neraca_saldo', $data)->render();
       $pdf = PDF::loadHTML($view)->setPaper('A4', 'landscape');
       return $pdf->stream();
    }
    private function neraca(array $data)
    {
        $data['title'] = 'Neraca';
        $view = view('pelaporan.partials.views.neraca', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function laba_rugi(array $data)
    {
        $data['title'] = 'Laba Rugi';
        $view = view('pelaporan.partials.views.laba_rugi', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function arus_kas(array $data)
    {
        $data['title'] = 'Laporan Arus Kas';
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
        $data['accounts'] = Account::where('lev1', '3')->get();
        $data['title'] = 'Laporan Perubahan Modal';
        $view = view('pelaporan.partials.views.laporan_perubahan_modal', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();

    }
    private function calk(array $data)
    {
        $data['title'] = 'Laba Rugi';
        $view = view('pelaporan.partials.views.calk', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function piutang_pelanggan(array $data)
    {
        $data['title'] = 'Daftar Piutang Pelanggan';
        $view = view('pelaporan.partials.views.piutang_pelanggan', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    
    }
    private function daftar_tagihan_pelanggan(array $data)
    {

    }
    private function daftar_piutang_pelanggan(array $data)
    {

    }
    private function ati(array $data)
    {
        $data['title'] = 'Daftar Aset Tetap';
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
        $data['title'] = 'Daftar Aset Tak Berwujud';
        $view = view('pelaporan.partials.views.aset_tak_berwujud', $data)->render();
        $pdf = PDF::loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    private function e_budgeting(array $data)
    {
        $data['nama_akun'] = $data['sub_laporan'];
        $view = view('pelaporan.partials.views.e_budgeting', $data)->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->stream();
    }
    private function awal_tahun(array $data)
    {

    }

}
