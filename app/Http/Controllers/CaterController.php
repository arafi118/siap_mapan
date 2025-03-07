<?php

namespace App\Http\Controllers;

use App\Models\Cater;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caters = Cater::where('business_id', Session::get('business_id'))->get();
        $title = 'Data Cater';
        return view('cater.index')->with(compact('title', 'caters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Register Cater';
        return view('cater.create')->with(compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            "nama",
            "alamat",
            "telpon",
            "username",
            "password",
            "wilayah",
            "jenis_kelamin"
        ]);

        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'username' => 'required',
            'password' => 'required',
            'wilayah' => 'required',
            'jenis_kelamin' => 'required'
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $create = Cater::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telpon' => $request->telpon,
            'username' => $request->username,
            'password' => $request->password,
            'wilayah' => $request->wilayah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'business_id' => Session::get('business_id')

        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Daftar  Cater berhasil disimpan',
            'cater' => $create
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cater $cater)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cater $cater)
    {
        $caters = Cater::where('business_id', Session::get('business_id'))->get();
        $title = 'Edit Cater';
        return view('cater.edit')->with(compact('title', 'caters', 'cater'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cater $cater)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'username' => 'required',
            'password' => 'required',
            'wilayah' => 'required',
            'jenis_kelamin' => 'required'
        ]);

        // Update data
        $cater->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'wilayah' => $request->wilayah,
            'alamat' => $request->alamat,
            'telpon' => $request->telpon,
            'username' => $request->username,
            'password' => $request->password, // Enkripsi password
        ]);

        return redirect('/caters')->with('jsedit', 'Cater berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cater $cater)
    {
        $cater->delete();
        return redirect('/caters')->with('success', 'Cater berhasil dihapus');
    }
}
