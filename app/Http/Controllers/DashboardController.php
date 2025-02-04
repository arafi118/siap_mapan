<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Business;
use App\Models\Installations;
use App\Models\Settings;
use App\Models\Usage;
use App\Utils\Keuangan;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $keuangan = new Keuangan;

        $Installation = Installations::count();
        $Usages = Installations::where('status', 'A')->with([
            'customer',
            'package',
            'oneUsage' => function ($query) {
                $query->where('tgl_akhir', '<=', date('Y-m-d'));
            }
        ])->get();
        $Tagihan = Usage::where([
            ['status', 'UNPAID'],
            ['tgl_akhir', '<', date('Y-m-d')]
        ])->count();

        $UsageCount = 0;
        foreach ($Usages as $usage) {
            if ($usage->one_usage != null) {
                $UsageCount += 1;
            }
        }

        $bulan = intval(date('m'));
        $chart = $this->chart();

        $pendapatan = $chart['pendapatan'];
        $beban = $chart['beban'];
        $surplus = $chart['surplus'];

        $pros_pendapatan = $keuangan->ProsSaldo($pendapatan[$bulan - 1], $pendapatan[$bulan]);
        $pros_beban = $keuangan->ProsSaldo($beban[$bulan - 1], $beban[$bulan]);
        $pros_surplus = $keuangan->ProsSaldo($surplus[$bulan - 1], $surplus[$bulan]);

        $charts = json_encode($chart);

        $today = date('Y-m-d');
        $year = date('Y');
        $month = date('m');

        $title = 'Dashboard';
        $api = env('APP_API', 'http://localhost:8080');
        $business = Business::where('id', Session::get('business_id'))->first();
        return view('welcome')->with(compact('Installation', 'UsageCount', 'Tagihan', 'title', 'charts', 'pendapatan', 'beban', 'surplus', 'pros_pendapatan', 'pros_beban', 'pros_surplus', 'business', 'api'));
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
            'installation.customer.village',
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

    private function chart()
    {
        $accounts = Account::where('business_id', Session::get('business_id'))->where(function ($query) {
            $query->where('lev1', '4')->orWhere('lev1', '5');
        })->with([
            'amount' => function ($query) {
                $query->where('tahun', date('Y'))->where('bulan', '<=', date('m'));
            }
        ])->get();

        $bulan = [];
        for ($i = 0; $i <= date('m'); $i++) {
            $bulan[$i] = [
                'pendapatan' => 0,
                'beban' => 0
            ];
        }

        foreach ($accounts as $account) {
            foreach ($account->amount as $amount) {
                $saldo = $amount->kredit - $amount->debit;
                if ($account->jenis_mutasi != 'kredit') {
                    $saldo = $amount->debit - $amount->kredit;
                }

                if ($account->lev1 == '4') {
                    $bulan[intval($amount->bulan)]['pendapatan'] += $saldo;
                } else {
                    $bulan[intval($amount->bulan)]['beban'] += $saldo;
                }
            }
        }

        $nama_bulan = [];
        $pendapatan = [];
        $beban = [];
        $surplus = [];
        foreach ($bulan as $key => $value) {

            $saldo_pendapatan = 0;
            $saldo_beban = 0;
            if ($key > 0) {
                $saldo_pendapatan = $value['pendapatan'] - $bulan[$key - 1]['pendapatan'];
                $saldo_beban = $value['beban'] - $bulan[$key - 1]['beban'];
            }

            $pendapatan[$key] = $saldo_pendapatan;
            $beban[$key] = $saldo_beban;
            $surplus[$key] = $saldo_pendapatan - $saldo_beban;

            if ($key == 0) {
                $nama_bulan[$key] = 'Awal Tahun';
            } else {
                $tanggal = date('Y-m-d', strtotime(date('Y') . '-' . $key . '-01'));
                $nama_bulan[$key] = Tanggal::namaBulan($tanggal);
            }
        }

        return [
            'nama_bulan' => $nama_bulan,
            'pendapatan' => $pendapatan,
            'beban' => $beban,
            'surplus' => $surplus
        ];
    }
}
