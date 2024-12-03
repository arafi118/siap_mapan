<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $villages = Village::all();

        $title = 'Data Desa';
        return view('pelanggan.index_desa')->with(compact('title','villages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desa = Village::all();

        $title = 'Register Desa';
        return view('pelanggan.create_desa')->with(compact('desa','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'kode' => 'required|unique:villages',
            'nama' => 'required',
            'alamat' => 'required',
            'hp' => 'required'
         ]);

        //  CARA 1
        Village::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'hp' => $request->hp
        ]);

        return redirect('/villages')->with('berhasil','Customer berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Village $village)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Village $village)
    {
        $title = 'Edit Desa';
        return view('pelanggan.edit_desa')->with(compact('village','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Village $village)
    {
        // Validasi input
        $validasi = [
            'kode' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'hp' => 'required'
        ];

        $this->validate($request, $validasi);
    
        // Update data 
        $update = $village::where('id', $village->id)->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'hp' => $request->hp
        ]);
    
        return redirect('/villages')->with('Berhasil', 'Desa berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Village $village)
    {
        //
    }
}
