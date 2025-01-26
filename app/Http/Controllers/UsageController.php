<?php

namespace App\Http\Controllers;

use App\Models\Cater;
use App\Models\Customer;
use App\Models\Installations;
use App\Models\Settings;
use App\Models\Usage;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsageController extends Controller
{

    public function index()
    {
        $usages = Usage::with([
            'customers',
            'installation'
        ])->orderBy('created_at', 'DESC')->get();

        $title = 'Data Pemakaian';
        return view('penggunaan.index')->with(compact('title', 'usages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // where('status','A')->
        $customer = Installations::with('customer')->orderBy('id', 'ASC')->get();
        $caters = Cater::all();
        $usages = Usage::all();
        $installasi = Installations::orderBy('id', 'ASC')->get();
        $pilih_customer = 0;

        $title = 'Register Pemakaian';
        return view('penggunaan.create')->with(compact('customer', 'pilih_customer', 'caters', 'title', 'usages'));
    }

    public function store(Request $request)
    {
        $insert = [];
        $tanggal = Tanggal::tglNasional($request->tanggal);
        foreach ($request->data as $data) {
            $insert[] = [
                'customer' => $data['customer'],
                'awal' => $data['awal'],
                'akhir' => $data['akhir'],
                'jumlah' => $data['jumlah'],
                'id_instalasi' => $data['id'],
                'tgl_akhir' => $tanggal,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        // Simpan data
        Usage::insert($insert);
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function carianggota(Request $request)
    {
        $query = $request->input('query');

        $customer = Customer::join('installations', 'customers.id', 'installations.customer_id')
            ->where('customers.nama', 'LIKE', '%' . $query . '%')
            ->orwhere('installations.kode_instalasi', 'LIKE', '%' . $query . '%')->get();

        $data_customer = [];
        foreach ($customer as $cus) {
            $usage = Usage::where('id_instalasi', $cus->id)->orderBy('created_at', 'DESC')->first();

            $data_customer[] = [
                'customer' => $cus,
                'usage' => $usage
            ];
        }


        return response()->json($data_customer);
    }
    public function show(Usage $usage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usage $usage)
    {
        $usages = Usage::with([
            'customers',
            'installation'
        ])->get();
        $title = 'Data Pemakaian';
        return view('penggunaan.edit')->with(compact('title', 'usage', 'usages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usage $usage)
    {
        $this->validate($request, [

            'tgl_akhir' => 'required|date'
        ]);

        // Mengubah format tanggal dari d/m/Y ke Y-m-d
        $tgl_akhir = \DateTime::createFromFormat('d/m/Y', $request->tgl_akhir)->format('Y-m-d');

        $usage->update([

            'tgl_akhir' => $tgl_akhir
        ]);

        return redirect('/usages')->with('berhasil', 'Usage berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usage $usage)
    {
        $usage->delete();
        return redirect('/usages')->with('success', 'Pemakaian berhasil dihapus');
    }
}
