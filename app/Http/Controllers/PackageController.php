<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::all();

        $title = 'Data Paket';
        return view('paket.index')->with(compact('title','packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paket = Package::all();

        $title = 'Register Paket';
        return view('paket.create')->with(compact('paket','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'kelas' => 'required',
            'harga' => 'required',
            'harga1' => 'required',
            'beban' => 'required',
            'denda' => 'required'
         ]);

            Package::create([
            'kelas' => $request->kelas,
            'harga' => $request->harga,
            'harga1' => $request->harga1,
            'abodemen' => $request->beban,
            'denda' => $request->denda
            
        ]);

        return redirect('/packages')->with('berhasil','Paket berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        $package->delete();
    
        // Redirect ke halaman customer dengan pesan sukses
        return redirect('/packages')->with('success', 'Paket berhasil dihapus');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {

        $title = 'Edit Paket';
        return view('paket.edit')->with(compact('title','package'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        // Validasi input
        $validasi = [
            'kelas' => 'required',
            'harga' => 'required',
            'harga1' => 'required',
            'beban' => 'required',
            'denda' => 'required'
        ];

        $this->validate($request, $validasi);
    
        // Update data 
        $update = Package::where('id', $package->id)->update([
            'kelas' => $request->kelas,
            'harga' => $request->harga,
            'harga1' => $request->harga1,
            'abodemen' => $request->beban,
            'denda' => $request->denda
        ]);
    
        return redirect('/packages')->with('Berhasil', 'Paket berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        //
    }
}
