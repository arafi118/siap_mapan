<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Region;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $villages = Village::all();

        $title = 'Data Desa';
        return view('desa.index')->with(compact('title', 'villages'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $provinsi = Region::whereRaw('LENGTH(kode)=2')->get();

        $title = 'Register Desa';
        return view('desa.create')->with(compact('provinsi', 'title'));
    }

    public function generateAlamat($kode)
    {
        // Memecah kode menjadi bagian-bagian
        $kode_provinsi = substr($kode, 0, 2);
        $kode_kabupaten = substr($kode, 0, 5);
        $kode_kecamatan = substr($kode, 0, 8);
        $kode_desa = $kode;

        // Mengambil data wilayah berdasarkan kode
        $provinsi = Region::where('kode', $kode_provinsi)->first();
        $kabupaten = Region::where('kode', $kode_kabupaten)->first();
        $kecamatan = Region::where('kode', $kode_kecamatan)->first();
        $desa = Region::where('kode', $kode_desa)->first();

        $alamat = '';
        if ($provinsi) {
            $alamat .= 'Provinsi ' . ucfirst(strtolower($provinsi->nama));
        }
        if ($kabupaten) {
            $alamat .= ', ' . ucfirst(strtolower($kabupaten->nama));
        }
        if ($kecamatan) {
            $alamat .= ', Kecamatan ' . ucfirst(strtolower($kecamatan->nama));
        }
        if ($desa) {
            $alamat .= ', Desa ' . ucfirst(strtolower($desa->nama));
        }

        return response()->json([
            'success' => true,
            'alamat' => $alamat
        ]);
    }

    public function ambil_kab($kode)
    {
        $kabupaten = Region::where('kode', 'LIKE', $kode . '%')->whereRaw('length(kode)=5')->get();

        return response()->json([
            'success' => true,
            'data' => $kabupaten
        ]);
    }

    public function ambil_kec($kode)
    {
        $kecamatan = Region::where('kode', 'LIKE', $kode . '%')->whereRaw('length(kode)=8')->get();

        return response()->json([
            'success' => true,
            'data' => $kecamatan
        ]);
    }

    public function ambil_desa($kode)
    {
        $desa = Region::where('kode', 'LIKE', $kode . '%')->whereRaw('length(kode)>8')->get();

        return response()->json([
            'success' => true,
            'data' => $desa
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'desa' => 'required',
            'alamat' => 'required',
            'hp' => 'required',
        ]);

        $tahun = date('Y');
        $bulan = date('m');
        $hari = date('d');

        $business_id = str_pad(Session::get('business_id'), 3, '0', STR_PAD_LEFT);

        $jumlah_urutan = '0001';
        $desa = Village::where('kode', 'LIKE', $business_id . '%');
        if ($desa->count() > 0) {
            // kode_desa = 2025.01.001
            $desa = $desa->orderBy('kode', 'DESC')->first();
            $kode_desa = explode('.', $desa->kode); // ['2025', '01', '001']

            $urutan = end($kode_desa);
            $kd_desa = array_pop($kode_desa);  // ['2025', '01']
            $jumlah_urutan = str_pad(intval($urutan) + 1, 4, '0', STR_PAD_LEFT);

            if (is_array($kd_desa)) {
                $kode_baru = implode('.', $kd_desa) . '.' . $jumlah_urutan;
            } else {
                $kode_baru = $kd_desa . '.' . $jumlah_urutan;
            }
        }

        $kode = $business_id .  '.' . $jumlah_urutan;
        $desa = Region::where('kode', $request->desa)->first();

        $Desa = Village::create([
            'kode' => $kode,
            'nama' => $desa->nama,
            'alamat' => $request->alamat,
            'hp' => $request->hp
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Desa berhasil ditambahkan!',
            'Desa' => $Desa
        ]);
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
        return view('desa.edit')->with(compact('village', 'title'));
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
        Village::where('id', $village->id)->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'hp' => $request->hp
        ]);

        return redirect('/villages')->with('jsedit', 'Desa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Village $village)
    {
        // Menghapus customer berdasarkan id yang diterima
        $village->delete();

        // Redirect ke halaman customer dengan pesan sukses
        return redirect('/villages')->with('success', 'Desa berhasil dihapus');
    }
}
