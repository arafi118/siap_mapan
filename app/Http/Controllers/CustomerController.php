<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Family;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('business_id','1');
        $customers = Customer::all();

        $title = 'Data penduduk';
        return view('pelanggan.index')->with(compact('title','customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desa = Village::all();
        $hubungan = Family::orderBy('id', 'ASC')->get();

        $title = 'Register Penduduk';
        return view('pelanggan.create')->with(compact('desa', 'hubungan','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            'nik' => 'required|unique:customers',
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_kk' => 'required',
            'nik_penjamin' => 'required',
            'penjamin' => 'required',
            'domisi' => 'required',
            'desa' => 'required',
            'no_telp' => 'required',
            'pendidikan' => 'required',
            'agama' => 'required',
            'status_pernikahan' => 'required',
            'nama_ibu' => 'required',
            'tempat_kerja' => 'required',
            'jenis_usaha' => 'required',
            'hubungan' => 'required',
         ]);

        //  CARA 1
        Customer::create([
            'nik' => $request->nik,
            'nama' => $request->nama_lengkap,
            'nama_panggilan' => $request->nama_panggilan,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jk' => $request->jenis_kelamin,
            'kk' => $request->no_kk,
            'nik_penjamin' => $request->nik_penjamin,
            'penjamin' => $request->penjamin,
            'domisi' => $request->domisi,
            'desa' => $request->desa,
            'hp' => $request->no_telp,
            'pendidikan' => $request->pendidikan,
            'agama' => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'nama_ibu' => $request->nama_ibu,
            'tempat_kerja' => $request->tempat_kerja,
            'usaha' => $request->jenis_usaha,
            'nik_penjamian' => $request->nik_penjamian,
            'hubungan' => $request->hubungan
        ]);

        return redirect('/customers')->with('berhasil','Customer berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Menghapus customer berdasarkan id yang diterima
        $customer->delete();
    
        // Redirect ke halaman customer dengan pesan sukses
        return redirect('/customers')->with('success', 'Customer berhasil dihapus');
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $desa = Village::all();
        $hubungan = Family::orderBy('id', 'ASC')->get();

        $title = 'Edit Pelanggan';
        return view('pelanggan.edit')->with(compact('desa', 'hubungan','customer','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Validasi input
        $validasi = [
            'nik' => 'required',
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_kk' => 'required',
            'nik_penjamin' => 'required',
            'penjamin' => 'required',
            'domisi' => 'required',
            'desa' => 'required',
            'no_telp' => 'required',
            'pendidikan' => 'required',
            'agama' => 'required',
            'status_pernikahan' => 'required',
            'nama_ibu' => 'required',
            'tempat_kerja' => 'required',
            'jenis_usaha' => 'required',
            'hubungan' => 'required',
        ];

        if ($request->nik != $customer->nik) {
            $validasi['nik'] = 'required|unique:customers';
        }

        $this->validate($request, $validasi);
    
        // Update data customer
        $update = Customer::where('id', $customer->id)->update([
            'nik' => $request->nik,
            'nama' => $request->nama_lengkap,
            'nama_panggilan' => $request->nama_panggilan,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jk' => $request->jenis_kelamin,
            'kk' => $request->no_kk,
            'nik_penjamin' => $request->nik_penjamin,
            'penjamin' => $request->penjamin,
            'domisi' => $request->domisi,
            'desa' => $request->desa,
            'hp' => $request->no_telp,
            'pendidikan' => $request->pendidikan,
            'agama' => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'nama_ibu' => $request->nama_ibu,
            'tempat_kerja' => $request->tempat_kerja,
            'usaha' => $request->jenis_usaha,
            'hubungan' => $request->hubungan
        ]);
    
        return redirect('/customers')->with('Berhasil', 'Customer berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
