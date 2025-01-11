<?php

namespace App\Http\Controllers;

use App\Models\Installations;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        Session::put('business_id', '1');
        $Installation = Installations::count();
        $Usage = Usage::where('status', 'PAID')->count();
        $Tagihan = Usage::where([
            ['status', 'UNPAID'],
            ['tgl_akhir', '<', date('Y-m-d')]
        ])->count();

        $today = date('Y-m-d');
        $year = date('Y');
        $month = date('m');

        $title = 'Dashboard';
        return view('welcome')->with(compact('Installation', 'Usage', 'Tagihan', 'title'));
    }

    public function installations()
    {
        $Permohonan = Installations::where('status', '0')->orwhere('status', 'R')->with([
            'customer',
            'package'
        ])->get();
        $Pasang = Installations::where('status', 'I')->with([
            'customer',
            'package'
        ])->get();
        $Aktif = Installations::where('status', 'A')->with([
            'customer',
            'package'
        ])->get();
        $Blokir = Installations::where('status', 'B')->with([
            'customer',
            'package'
        ])->get();
        $Cabut = Installations::where('status', 'C')->with([
            'customer',
            'package'
        ])->get();

        return response()->json([
            'Permohonan' => $Permohonan,
            'Pasang' => $Pasang,
            'Aktif' => $Aktif,
            'Blokir' => $Blokir,
            'Cabut' => $Cabut
        ]);
    }

    public function usages()
    {
        $Usages = Installations::where('status', 'A')->with([
            'customer',
            'package',
            'usage'
        ])->get();

        return response()->json([
            'Usages' => $Usages
        ]);
    }

    public function tagihan()
    {
        $tgl_akhir = request()->get('tgl_akhir') ?: date('Y-m-d');
        $Tagihan = Usage::where([
            ['status', 'UNPAID'],
            ['tgl_akhir', '<', $tgl_akhir]
        ])->with([
            'installation',
            'installation.customer',
            'installation.package'
        ])->get();

        return response()->json([
            'Tagihan' => $Tagihan
        ]);
    }
}
