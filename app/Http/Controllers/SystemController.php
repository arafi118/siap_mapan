<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Installations;
use App\Models\Transaction;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SystemController extends Controller
{
    public function dataset($waktu)
    {
        $date = date('Y-m-d', $waktu);
        $created_at = date('Y-m-d H:i:s');
        $businessId = Session::get('business_id');
        $installations = Installations::where('business_id', Session::get('business_id'))->with([
            'usage' => function ($query) use ($date) {
                $query->where('status', 'UNPAID')->where('tgl_akhir', '<=', $date);
            },
            'usage.transaction'
        ])->get();

        $debit = Account::where([
            ['business_id', $businessId],
            ['kode_akun', '1.1.03.01']
        ])->first();
        $kredit = Account::where([
            ['business_id', $businessId],
            ['kode_akun', '4.1.01.02']
        ])->first();

        $update_sps = [];
        $trx_tunggakan = [];
        foreach ($installations as $ins) {
            if (count($ins->usage) >= 3) {
                $update_sps[] = $ins->id;
            }

            foreach ($ins->usage as $usage) {
                $tgl_toleransi = date('Y-m-t', strtotime('+1 month', strtotime($usage->tgl_akhir)));
                if ($tgl_toleransi < $date && count($usage->transaction) == 0) {
                    $trx_tunggakan[] = [
                        'business_id' => $businessId,
                        'tgl_transaksi' => $usage->tgl_akhir,
                        'rekening_debit' => $debit->id,
                        'rekening_kredit' => $kredit->id,
                        'user_id' => '1',
                        'usage_id' => $usage->id,
                        'installation_id' => $usage->id_instalasi,
                        'total' => $usage->nominal,
                        'denda' => '0',
                        'relasi' => $usage->customers->nama,
                        'keterangan' => 'Pendapatan Piutang pemakaian atas nama ' . $usage->customers->nama,
                        'urutan' => '0',
                        'created_at' => $created_at
                    ];
                }
            }
        }

        Installations::whereIn('id', $update_sps)->update(['status_tunggakan' => 'sps']);
        DB::statement('SET @DISABLE_TRIGGER = 1');
        Transaction::insert($trx_tunggakan);
        DB::statement('SET @DISABLE_TRIGGER = 0');

        echo '<script>window.close()</script>';
        exit;
    }
}
?>

<!-- Pendapatan abodemen, denda, penggunaan air
Tanggal 27 if (tagihan) jurnal => piutang usaha
if pembayaran bulanan sps, ada 2 transaksi
1. piutang ke kas
2. trx komisi utang sps (2.1.02) ke fee kolektor | 10% dari total -->