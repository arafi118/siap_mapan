<?php

namespace App\Http\Controllers;

use App\Models\Cater;
use App\Models\jabatan;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caters = Cater::with([
            'position'
        ])->get();
        $title = 'Data Cater';
        return view('cater.index')->with(compact('title', 'caters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = Position::all();

        $title = 'Register Cater';
        return view('cater.create')->with(compact('positions', 'title'));
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
            "jabatan",
            "username",
            "password",
            "jenis_kelamin"
        ]);

        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'jabatan' => 'required',
            'username' => 'required',
            'password' => 'required',
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
            'jabatan' => $request->jabatan,
            'username' => $request->username,
            'password' => $request->password,
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
        $positions = Position::all();
        $caters = Cater::with('position')->get();
        $title = 'Edit Cater';
        return view('cater.edit')->with(compact('title', 'positions', 'caters', 'cater'));
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
            'jabatan' => 'required',
            'username' => 'required',
            'password' => 'required',
            'jenis_kelamin' => 'required'
        ]);

        // Update data
        $cater->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telpon' => $request->telpon,
            'jabatan' => $request->jabatan, // Pastikan data sesuai tipe
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
