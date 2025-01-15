<?php

namespace App\Http\Controllers;

use App\Models\Installations;
use App\Models\Settings;
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

        return response()->json([
            'Permohonan' => $Permohonan,
            'Pasang' => $Pasang,
            'Aktif' => $Aktif
        ]);
    }

    public function usages()
    {
        $Usages = Installations::where('status', 'A')->with([
            'customer',
            'package',
            'oneUsage' => function ($query) {
                $query->where('tgl_akhir', '<=', date('Y-m-d'));
            }
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
        $setting = Settings::where('business_id', Session::get('business_id'))->first();

        $result = [];
        $block = json_decode($setting->block, true);
        foreach ($block as $index => $item) {
            preg_match_all('/\d+/', $item['jarak'], $matches);
            $start = (int)$matches[0][0];
            $end = (int)$matches[0][1];

            for ($i = $start; $i <= $end; $i++) {
                $result[$i] = $index;
            }
        }

        return response()->json([
            'Tagihan' => $Tagihan,
            'setting' => $setting,
            'block' => $result
        ]);
    }
}
