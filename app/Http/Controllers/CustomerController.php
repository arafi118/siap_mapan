<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Installations;
use App\Models\Family;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;
use App\Utils\Keuangan;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::where('business_id', Session::get('business_id'))->with('installation')->get();

        $title = 'Data penduduk';
        return view('pelanggan.index')->with(compact('title', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desa = Village::all();
        $hubungan = Family::orderBy('id', 'ASC')->get();

        $title = 'Register Penduduk';
        return view('pelanggan.create')->with(compact('desa', 'hubungan', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            "nik",
            "nama_lengkap",
            "nama_panggilan",
            "alamat",
            "tempat_lahir",
            "tgl_lahir",
            "jenis_kelamin",
            "no_kk",
            "domisi",
            "desa",
            "no_telp",
        ]);

        $rules = [
            'nik' => 'required|unique:customers',
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_kk' => 'required',
            'domisi' => 'required',
            'desa' => 'required',
            'no_telp' => 'required',
        ];

        $validate = Validator::make($data, $rules);
        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }


        $create = Customer::create([
            'business_id' => Session::get('business_id'),
            'nik' => $request->nik,
            'nama' => $request->nama_lengkap,
            'nama_panggilan' => $request->nama_panggilan,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' =>  Tanggal::tglNasional($request->tgl_lahir),
            'jk' => $request->jenis_kelamin,
            'kk' => $request->no_kk,
            'domisi' => $request->domisi,
            'desa' => $request->desa,
            'hp' => $request->no_telp
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Customer berhasil Ditambahkan!',
            'installation' => $create
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Menghapus customer berdasarkan id yang diterima

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $desa = Village::all();
        $hubungan = Family::orderBy('id', 'ASC')->get();

        $title = 'Edit Pelanggan';
        return view('pelanggan.edit')->with(compact('desa', 'hubungan', 'customer', 'title'));
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
            'domisi' => 'required',
            'desa' => 'required',
            'no_telp' => 'required'
        ];

        if ($request->nik != $customer->nik) {
            $validasi['nik'] = 'required|unique:customers';
        }

        $this->validate($request, $validasi);

        // Update data customer
        Customer::where('business_id', Session::get('business_id'))->where('id', $customer->id)->update([
            'nik' => $request->nik,
            'nama' => $request->nama_lengkap,
            'nama_panggilan' => $request->nama_panggilan,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jk' => $request->jenis_kelamin,
            'kk' => $request->no_kk,
            'domisi' => $request->domisi,
            'desa' => $request->desa,
            'hp' => $request->no_telp
        ]);

        return redirect('/customers')->with('success', 'Customer berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Customer $customer)
    {
        // Cek jika customer masih memiliki status di tabel installations
        $Cek_Instal = Installations::where('business_id', Session::get('business_id'))->where('customer_id', $customer->id)->exists();

        if ($Cek_Instal) {
            return response()->json([
                'success' => false, // Operasi gagal karena ada status Pemakaian
                'msg' => 'Customer tidak dapat dihapus karena masih memiliki status Pemakaian.',
            ]);
        }

        // Hapus customer
        $customer->delete();

        return response()->json([
            'success' => true, // Operasi berhasil
            'msg' => 'Customer berhasil dihapus.',
        ]);
    }
}
