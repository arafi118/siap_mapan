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
    { {
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
            $biaya_sudah_dibayar = $data['biaya_sudah_dibayar'];
            $biaya_instalasi = $data['pembayaran'];

            $penjumlahantrx = $biaya_sudah_dibayar + $biaya_instalasi;
            $biaya_instal = $data['abodemen'] - $penjumlahantrx;

            $status = '0';
            $jumlah = $biaya_instal;
            if ($jumlah <= 0) {
                $status = 'P';
            }


            // TRANSACTION TIDAK BOLEH NYICIL
            $jumlah_instal = ($biaya_instal >= 0) ? $biaya_instalasi : $biaya_sudah_dibayar;
            $persen = 100 - ($jumlah / $biaya_sudah_dibayar * 100);
            $persen = ($penjumlahantrx / $abodemen) * 100;

            $transaksi = Transaction::create([
                'rekening_debit' => '1',
                'rekening_kredit' => '67',
                'tgl_transaksi' => Tanggal::tglNasional($request->tgl_transaksi),
                'total' => $jumlah_instal,
                'installation_id' => $request->transaction_id,
                'keterangan' => 'Biaya istalasi ' . $persen . '%',
            ]);
            dd($transaksi);

            return response()->json([
                'success' => true,
                'msg' => 'Daftar & Instalasi berhasil disimpan',
                'installation' => $transaksi
            ]);
        }
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
