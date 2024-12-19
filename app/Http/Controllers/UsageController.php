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
<<<<<<< HEAD
        $customer = Installations::with('customer', 'package')->orderBy('id', 'ASC')->get();
        $usages = Usage::all();

        $title = 'Data Pemakaian';
        return view('penggunaan.index')->with(compact('title', 'usages', 'customer'));
=======
        $usages = Usage::with([
            'customers',
            'installation'
        ])->get();

        $title = 'Data Pemakaian';
        return view('penggunaan.index')->with(compact('title','usages'));
>>>>>>> 1f144f8e49c49c713f8348d527a58cb03505d0d9
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // where('status','A')->
<<<<<<< HEAD
        $customer = Installations::with('customer', 'package')->orderBy('id', 'ASC')->get();
        $setting = Settings::where('business_id', Session::get('business_id'))->first();
=======
        $customer = Installations::with('customer')->orderBy('id', 'ASC')->get();
>>>>>>> 1f144f8e49c49c713f8348d527a58cb03505d0d9
        $caters = Cater::all();
        $installasi = Installations::orderBy('id', 'ASC')->get();
        $pilih_customer = 0;



        $title = 'Register Pemakaian';
<<<<<<< HEAD
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
=======
        return view('penggunaan.create')->with(compact('customer','pilih_customer','caters','title'));
>>>>>>> 1f144f8e49c49c713f8348d527a58cb03505d0d9
    }

    public function store(Request $request)
    {
        $this->validate($request, [
<<<<<<< HEAD
            'kode_instalasi' => 'required',
=======
>>>>>>> 1f144f8e49c49c713f8348d527a58cb03505d0d9
            'customer' => 'required',
            'awal' => 'required',
            'akhir' => 'required',
            'jumlah' => 'required',
<<<<<<< HEAD
            'tgl_akhir' => 'required',
            'cater' => 'required'
        ]);
=======
            'tgl_akhir' => 'required|date'
        ]);
        
>>>>>>> 1f144f8e49c49c713f8348d527a58cb03505d0d9

        Usage::create([

            'customer' => $request->customer,
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'jumlah' => $request->jumlah,
            'tgl_akhir' => $request->tgl_akhir
        ]);
        

        return redirect('/usages')->with('berhasil', 'Usage berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function carianggota(Request $request)
    {
        $query = $request->input('query');

        // SELECT * FROM customers JOIN installations ON customers.id = installations.customer_id
        $customer = Customer::join('installations', 'customers.id','installations.customer_id')
                // WHERE customers.nama LIKE '%$query%'
                ->where('customers.nama', 'LIKE' ,'%' . $query . '%')
                // OR installations.kode_instalasi LIKE '%$query%';
                ->orwhere('installations.kode_instalasi', 'LIKE' ,'%' . $query . '%')->get();
        
        $data_customer = [];
        foreach ($customer as $cus) {
            $usage = Usage::where('kode_instalasi', $cus->kode_instalasi)->orderBy('created_at','DESC')->first();

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
