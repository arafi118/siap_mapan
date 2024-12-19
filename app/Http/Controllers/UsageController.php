<?php

namespace App\Http\Controllers;

use App\Models\Cater;
use App\Models\Customer;
use App\Models\Installations;
use App\Models\Settings;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Installations::with('customer', 'package')->orderBy('id', 'ASC')->get();
        $usages = Usage::all();

        $title = 'Data Pemakaian';
        return view('penggunaan.index')->with(compact('title', 'usages', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // where('status','A')->
        $customer = Installations::with('customer', 'package')->orderBy('id', 'ASC')->get();
        $setting = Settings::where('business_id', Session::get('business_id'))->first();
        $caters = Cater::all();
        $installasi = Installations::orderBy('id', 'ASC')->get();
        $pilih_customer = 0;



        $title = 'Register Pemakaian';
        return view('penggunaan.create')->with(compact('customer', 'setting', 'pilih_customer', 'caters', 'title'));
    }
    public function cariAnggota(Request $request)
    {
        $query = $request->input('query');

        // $customer = Installations::with([
        //     'customer' => function ($q) use ($query) {
        //         $q->where('nama', 'LIKE', "%{$query}%");
        //     },
        //     'package',
        //     'installation' => function ($query) {
        //         $query->where('status', '0');
        //     },
        //     'caters',
        // ])->get();

        // SELECT * FROM customers JOIN installations ON customers.id = installations.customer_id
        $customer = Customer::join('installations', 'customers.id', 'installations.customer_id')
            //WHERE customers.nama LIKE '%$query%'
            ->where('customers.nama', 'LIKE', '%' . $query . '%')
            // OR installations.kode_instalasi LIKE '%$query%';
            ->orwhere('installations.kode_instalasi', 'LIKE', '%' . $query . '%')->get();

        return response()->json($customer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_instalasi' => 'required',
            'customer' => 'required',
            'awal' => 'required',
            'akhir' => 'required',
            'jumlah' => 'required',
            'tgl_akhir' => 'required',
            'cater' => 'required'
        ]);

        //  CARA 1
        Usage::create([
            'kode_instalasi' => $request->kode_instalasi,
            'customer' => $request->customer,
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'jumlah' => $request->jumlah,
            'tgl_akhir' => $request->tgl_akhir,
            'cater' => $request->cater
        ]);

        return redirect('/usages')->with('berhasil', 'Usage berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
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
