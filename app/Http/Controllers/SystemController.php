<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Amount;
use App\Models\Installations;
use App\Models\Settings;
use App\Models\Transaction;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SystemController extends Controller
{
    public function dataset($waktu)
    {
        $businessId = Session::get('business_id');

        $date = date('Y-m-d', $waktu);
        $createdAt = now();

        $accounts = Account::where('business_id', $businessId)
            ->whereIn('kode_akun', ['1.1.03.01', '4.1.01.02', '4.1.01.03', '4.1.01.04'])
            ->get()
            ->keyBy('kode_akun');

        $kodePiutang   = $accounts['1.1.03.01'] ?: null;
        $kodeAbodemen  = $accounts['4.1.01.02'] ?: null;
        $kodePemakaian = $accounts['4.1.01.03'] ?: null;
        $kodeDenda     = $accounts['4.1.01.04'] ?: null;

        if (!($kodePiutang && $kodeAbodemen && $kodePemakaian && $kodeDenda)) {
            return;
        }

        $installations = Installations::where('business_id', $businessId)->where('id', '9343')->with([
            'package',
            'usage' => function ($query) use ($date) {
                $query->where('status', 'UNPAID')
                    ->where('tgl_akhir', '<=', $date)
                    ->orderBy('tgl_akhir')
                    ->orderBy('id');
            },
            'usage.transaction',
            'usage.customers'
        ])->get();

        $dataUsage = [];
        $updateSps = [];
        $trxTunggakan = [];

        foreach ($installations as $ins) {
            $usages = $ins->usage;

            if ($usages->count() >= 3) {
                $updateSps[] = $ins->id;
            }

            $abodemen = $ins->abodemen;
            $denda = $ins->package->denda;

            foreach ($usages as $usage) {
                $jumlahPembayaran = $usage->transaction
                    ->where('rekening_kredit', $kodePemakaian->id)
                    ->sum('total');

                if ($usage->tgl_akhir <= $date && $jumlahPembayaran <= $usage->nominal) {
                    $trxId = 'PT-' . substr(password_hash($usage->id, PASSWORD_DEFAULT), 7, 6);

                    $nama = $usage->customers->nama ?: '-';
                    $instId = $ins->id;
                    $usageId = $usage->id;
                    $idInstalasi = $usage->id_instalasi;

                    $namaBulan = Tanggal::namaBulan($usage->tgl_pemakaian) . ' ' . Tanggal::tahun($usage->tgl_pemakaian);
                    $trxTunggakan[] = [
                        'business_id' => $businessId,
                        'tgl_transaksi' => $usage->tgl_akhir,
                        'rekening_debit' => $kodePiutang->id,
                        'rekening_kredit' => $kodeAbodemen->id,
                        'user_id' => auth()->user()->id,
                        'usage_id' => $usageId,
                        'installation_id' => $idInstalasi,
                        'transaction_id' => $trxId,
                        'total' => $abodemen,
                        'relasi' => $nama,
                        'keterangan' => "Utang Abodemen " . $namaBulan . " $nama ($instId)",
                        'urutan' => 0,
                        'created_at' => $createdAt
                    ];

                    if ($usage->jumlah != 0) {
                        $trxTunggakan[] = [
                            'business_id' => $businessId,
                            'tgl_transaksi' => $usage->tgl_akhir,
                            'rekening_debit' => $kodePiutang->id,
                            'rekening_kredit' => $kodePemakaian->id,
                            'user_id' => auth()->user()->id,
                            'usage_id' => $usageId,
                            'installation_id' => $idInstalasi,
                            'transaction_id' => $trxId,
                            'total' => $usage->nominal - $jumlahPembayaran,
                            'relasi' => $nama,
                            'keterangan' => "Utang Pemakaian Air " . $namaBulan . " $nama ($instId)",
                            'urutan' => 0,
                            'created_at' => $createdAt
                        ];
                    }

                    $trxTunggakan[] = [
                        'business_id' => $businessId,
                        'tgl_transaksi' => $usage->tgl_akhir,
                        'rekening_debit' => $kodePiutang->id,
                        'rekening_kredit' => $kodeDenda->id,
                        'user_id' => auth()->user()->id,
                        'usage_id' => $usageId,
                        'installation_id' => $idInstalasi,
                        'transaction_id' => $trxId,
                        'total' => $denda,
                        'relasi' => $nama,
                        'keterangan' => "Utang Denda " . $namaBulan . " $nama ($instId)",
                        'urutan' => 0,
                        'created_at' => $createdAt
                    ];

                    $dataUsage[] = $usageId;
                }
            }
        }

        if (!empty($updateSps)) {
            Installations::whereIn('id', $updateSps)->update(['status_tunggakan' => 'sps']);
        }

        if (!empty($trxTunggakan)) {
            DB::statement('SET @DISABLE_TRIGGER = 1');
            Transaction::whereIn('usage_id', $dataUsage)
                ->where('rekening_debit', $kodePiutang->id)
                ->delete();
            Transaction::insert($trxTunggakan);
            DB::statement('SET @DISABLE_TRIGGER = 0');
        }

        $this->saldo(date('Y', $waktu), date('m', $waktu), ...[
            $kodePiutang->id,
            $kodeAbodemen->id,
            $kodePemakaian->id,
            $kodeDenda->id
        ]);

        echo '<script>window.close()</script>';
        exit;
    }

    private function saldo($tahun, $bulan, ...$akun)
    {
        $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $date = "$tahun-$bulan-01";
        $tglKondisi = date('Y-m-t', strtotime($date));
        $bulanLalu = str_pad($bulan - 1, 2, '0', STR_PAD_LEFT);
        $businessId = Session::get('business_id');

        $accounts = Account::where('business_id', $businessId)
            ->whereIn('id', $akun)
            ->with([
                'trx_debit' => fn ($q) => $q->whereBetween('tgl_transaksi', [$date, $tglKondisi]),
                'trx_kredit' => fn ($q) => $q->whereBetween('tgl_transaksi', [$date, $tglKondisi]),
                'oneAmount' => fn ($q) => $q->where('tahun', $tahun)->where('bulan', $bulanLalu)
            ])->get();

        $amounts = [];
        $dataIds = [];

        foreach ($accounts as $account) {
            $id = $account->id . $tahun . $bulan;
            $debit = ($account->oneAmount->debit ?: 0) + $account->trx_debit->sum('total');
            $kredit = ($account->oneAmount->kredit ?: 0) + $account->trx_kredit->sum('total');

            $amounts[] = [
                'id' => $id,
                'account_id' => $account->id,
                'tahun' => $tahun,
                'bulan' => $bulan,
                'debit' => $debit,
                'kredit' => $kredit
            ];
            $dataIds[] = $id;
        }

        if (!empty($dataIds)) {
            Amount::whereIn('id', $dataIds)->delete();
            Amount::insert($amounts);
        }
    }
}
