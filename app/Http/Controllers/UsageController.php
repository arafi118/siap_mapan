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
        $usages = Usage::with([
            'customers',
            'installation'
        ])->get();

        $title = 'Data Pemakaian';
        return view('penggunaan.index')->with(compact('title','usages'));
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
        return view('penggunaan.create')->with(compact('customer','pilih_customer','caters','title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'customer' => 'required',
            'awal' => 'required',
            'akhir' => 'required',
            'jumlah' => 'required',
            'tgl_akhir' => 'required|date'
        ]);
        

        Usage::create([

            'customer' => $request->customer,
            'awal' => $request->awal,
            'akhir' => $request->akhir,
            'jumlah' => $request->jumlah,
            'tgl_akhir' => $request->tgl_akhir
        ]);
        

        return redirect('/usages')->with('berhasil','Usage berhasil Ditambahkan!');
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
