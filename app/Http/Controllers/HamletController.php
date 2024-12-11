<?php

namespace App\Http\Controllers;

use App\Models\Hamlet;
use App\Models\Village;
use Illuminate\Http\Request;

class HamletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hamlets = Hamlet::with('village')->get();
        $desa = Village::orderBy('id', 'ASC')->get();

        $title = 'Data Dusun';
        return view('dusun.index')->with(compact('title','hamlets','desa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desa = Village::all();

        $title = 'Register Dusun';
        return view('dusun.create')->with(compact('desa', 'title'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'id_desa' => 'required',
            'dusun' => 'required',
            'alamat' => 'required',
            'hp' => 'required'
         ]);

        Hamlet::create([
            'id_desa' => $request->id_desa,
            'dusun' => $request->dusun,
            'alamat' => $request->alamat,
            'hp' => $request->hp
          
        ]);

        return redirect('/hamlets')->with('berhasil','Dusun berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hamlet $hamlet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hamlet $hamlet)
    {
        $title = 'Edit Dusun';
        return view('Dusun.edit')->with(compact('hamlet','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hamlet $hamlet)
    {
         // Validasi input
         $validasi = [
            'id_desa' => 'required',
            'dusun' => 'required',
            'alamat' => 'required',
            'hp' => 'required'
        ];

        $this->validate($request, $validasi);
    
        // Update data 
        $update = $hamlet::where('id', $hamlet->id)->update([
            'id_desa' => $request->id_desa,
            'dusun' => $request->dusun,
            'alamat' => $request->alamat,
            'hp' => $request->hp
        ]);
    
        return redirect('/hamlets')->with('Berhasil', 'Dusun berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hamlet $hamlet)
    {
        $hamlet->delete();
        return redirect('/hamlets')->with('success', 'Dusun berhasil dihapus');

    }
}
