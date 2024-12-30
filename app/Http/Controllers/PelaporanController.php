<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Business;
use App\Models\Calk;
use App\Models\JenisLaporan;
use App\Models\User;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        if ($file == 3) {
            $accounts = Account::orderBy('kode_akun', 'ASC')->get();
            return view('pelaporan.partials.sub_laporan')->with(compact('file', 'accounts'));
        }

        if ($file == 'calk') {
            $tahun = request()->get('tahun');
            $bulan = request()->get('bulan');

            $calk = Calk::where([
                ['business_id',Session::get('business_id')],
                ['tanggal', 'LIKE', $tahun . '-' . $bulan . '%']
            ])->first();

            $keterangan = '';
            if ($calk) {
                $keterangan = $calk->catatan;
            }

            return view('pelaporan.partials.sub_laporan')->with(compact('file', 'keterangan'));
        }

        if ($file == 14) {
            $data = [
                0 => [
                    'title' => '01. Januari - Maret',
                    'id' => '1,2,3'
                ],
                1 => [
                    'title' => '02. April - Juni',
                    'id' => '4,5,6'
                ],
                2 => [
                    'title' => '03. Juli - September',
                    'id' => '7,8,9'
                ],
                3 => [
                    'title' => '04. Oktober - Desember',
                    'id' => '10,11,12'
                ]
            ];

            return view('pelaporan.partials.sub_laporan')->with(compact('file', 'data'));
        }

        if ($file == 'tutup_buku') {
            $data = [
                0 => [
                    'title' => 'Pengalokasian Laba',
                    'file' => 'alokasi_laba'
                ],
                1 => [
                    'title' => 'Jurnal Tutup Buku',
                    'file' => 'jurnal_tutup_buku'
                ],
                2 => [
                    'title' => 'Neraca',
                    'file' => 'neraca_tutup_buku'
                ],
                3 => [
                    'title' => 'Laba Rugi',
                    'file' => 'laba_rugi_tutup_buku'
                ],
                4 => [
                    'title' => 'CALK',
                    'file' => 'CALK_tutup_buku'
                ]
            ];

            return view('pelaporan.partials.sub_laporan')->with(compact('file', 'data'));
        }

        return view('pelaporan.partials.sub_laporan')->with(compact('file'));
    }
    public function preview(Request $request, $business_id = null)
    {
        // 
    }
}
