<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Family;
use App\Models\Installations;
use App\Models\Package;
use App\Models\Region;
use App\Models\Transaction;
use App\Models\Usage;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;
use App\Utils\Keuangan;

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
        $data = $request->only([
            "kelas",
            "harga",
            "abodemen",
            "denda"
        ]);
        $rules = [
            'kelas' => 'required',
            'harga' => 'required',
            'abodemen' => 'required',
            'denda' => 'required'
        ];
        $validate = Validator::make($data,$rules);

        if ($validate->fails()) {
        return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $Package =Package::create([
            'kelas' => $request->kelas,
            'harga' => $request->harga,
            'abodemen' => $request->abodemen,
            'denda' => $request->denda
            
        ]);
        return response()->json([
        'success' => true,
        'msg' => 'Paket berhasil disimpan',
        'simpanpackage' => $Package
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
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
        $data = $request->only([
            "kelas",
            "harga",
            "abodemen",
            "denda"
            ]);
        $rules = [
            'kelas' => 'required',
            'harga' => 'required',
            'abodemen' => 'required',
            'denda' => 'required'
        ];

        $validate = Validator::make($data,$rules);

        if ($validate->fails()) {
        return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }
        // Update data 
        $update = Package::where('id', $package->id)->update([
            'kelas' => $request->kelas,
            'harga' => $request->harga,
            'abodemen' => $request->abodemen,
            'denda' => $request->denda
        ]);

        return response()->json([
        'success' => true,
        'msg' => 'Edit Paket berhasil disimpan',
        'Editpackage' => $update
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {

        // $package->delete();

    package::where('id', $package->id)->delete();
        return response()->json([
        'success' => true,
        'msg' => 'Data Paket berhasil dihapus',
        'installation' => $package
        ]);
    }
}
