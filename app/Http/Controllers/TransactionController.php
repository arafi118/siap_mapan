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
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;
use App\Utils\Keuangan;

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

    public function tagihan_bulanan()
    {
        $transactions = Transaction::all();
        $installations = Installations::all();
        $status_0 = Installations::where('status', '0')->with(
            'customer',
            'village',
            'package'
        )->get();
        $title = 'Pelunasan Instalasi';
        return view('transaksi.tagihan_bulanan')->with(compact('title', 'transactions', 'status_0'));
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
     * Create data Pelunasan Instalasi.
     */
    private function Createpelunasaninstalasi($request)
    {
        $data = $request->only([
            "tgl_transaksi",
            "transaction_id",
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
            'installation_id' => $request->transaction_id,
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
            'transaksi' => $transaksi
        ]);
    }

    /**
     * Create data Pelunasan Instalasi.
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
            'transaksi' => $transaksi
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
