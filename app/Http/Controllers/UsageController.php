<?php

namespace App\Http\Controllers;

use App\Models\Cater;
use App\Models\Customer;
use App\Models\Installations;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UsageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usages = Usage::with([
            'customers',
            'installation'
        ])->get();

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
        $installasi = Installations::orderBy('id', 'ASC')->get();
        $pilih_customer = 0;



        $title = 'Register Pemakaian';
        return view('penggunaan.create')->with(compact('customer', 'pilih_customer', 'caters', 'title'));
    }

    public function store(Request $request)
    {
        $data = $request->only([
            "id_custommers",
            "id_installations",
            "awal",
            "akhir",
            "jumlah",
            "tgl_akhir",
        ]);
        dd($data);
        $rules = [
            'awal' => 'required',
            'akhir' => 'required',
            'jumlah' => 'required',
            'tgl_akhir' => 'required'
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        // INSTALLATION
        $install = Usage::create([
            'business_id' => Session::get('business_id'),
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'tgl_akhir' => $request->tgl_akhir,
            'jumlah' => $request->jumlah,
            'kode_instalasi' => $request->id_installations,
            'customer' => $request->id_custommers,
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Daftar & Instalasi berhasil disimpan',
            'usage' => $install
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function carianggota(Request $request)
    {
        $query = $request->input('query');

        // SELECT * FROM customers JOIN installations ON customers.id = installations.customer_id
        $customer = Customer::join('installations', 'customers.id', 'installations.customer_id')
            // WHERE customers.nama LIKE '%$query%'
            ->where('customers.nama', 'LIKE', '%' . $query . '%')
            // OR installations.kode_instalasi LIKE '%$query%';
            ->orwhere('installations.kode_instalasi', 'LIKE', '%' . $query . '%')->get();

        $data_customer = [];
        foreach ($customer as $cus) {
            $usage = Usage::where('kode_instalasi', $cus->kode_instalasi)->orderBy('created_at', 'DESC')->first();

            $data_customer[] = [
                'customer' => $cus,
                'usage' => $usage,
                'installasion' => $cus
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usage $usage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usage $usage)
    {
        //
    }
}
