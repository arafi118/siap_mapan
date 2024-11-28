<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Family;
use App\Models\Installations;
use App\Models\Package;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\Tanggal;

use Illuminate\Support\Facades\Validator;


class InstallationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $installations = Installations::all();

        $title = 'Proposal';
        return view('perguliran.index')->with(compact('title','installations'));   
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paket = Package::all();
        $installations = Installations::all();
        $customer = Customer::with('Village')->orderBy('id', 'ASC')->get();
        $desa = Village::all();

        $pilih_desa =0;
        $title = 'Register Proposal'; 
        return view('perguliran.create')->with(compact('paket','installations','customer', 'desa', 'pilih_desa', 'title'));
    }    

    public function kode_instalasi()
    {
        $kd_desa = request()->get('kode');
        $jumlah_kode_instalasi_by_desa = Installations::where('desa', $kd_desa)->orderBy('kode_instalasi', 'DESC');

        $desa = Village::where('id', $kd_desa)->first();
        $kd_prov = substr($desa->kode, 0, 2);
        $kd_kab = substr($desa->kode, 2, 2);
        $kd_kec = substr($desa->kode, 4, 2);
        $kd_desa = substr($desa->kode, 6, 4);
        $kode_instalasi = $kd_prov . '.' . $kd_kab . '.' . $kd_kec . '.' . $kd_desa;

        if ($jumlah_kode_instalasi_by_desa->count() > 0) {
            $jumlah = str_pad(($jumlah_kode_instalasi_by_desa->count() + 1), 3, "0", STR_PAD_LEFT);
        } else {
            $jumlah = str_pad(Installations::where('desa', $kd_desa)->count() + 1, 3, "0", STR_PAD_LEFT);
        }
        
        $kode_instalasi .= '.' . $jumlah;

        if (request()->get('kd_instalasi')) {
            $kd_ins = request()->get('kd_instalasi');
            $instalasi = Installations::where('kd_instalasi', $kd_ins);
                if ($instalasi->count() > 0) {
                    $data_ins = $instalasi->first();

                if ($kd_desa == $data_ins->desa) {
                    $kode_instalasi = $data_ins->kd_instalasi;
                }
            }
        }
    
        return response()->json([
                'kd_instalasi' => $kode_instalasi
            ], Response::HTTP_ACCEPTED);
        }

    public function janis_paket($id)
    {
        $package = Package::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'view' => view('perguliran.partials.jenis_paket')->with(compact('package'))->render()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $data = $request->only([
    'kode_instalasi',
    'customer_id',
    'order',
    'desa',
    'alamat',
    'koordinate',
    'package_id'
    ]);
    $rules = [
    'kode_instalasi' => 'required',
    'customer_id' => 'required',
    'order' => 'required',
    'desa' => 'required',
    'alamat' => 'required',
    'koordinate'=> 'required',
    'package_id' => 'required'
    ];

    $validate = Validator::make($data,$rules);

    if ($validate->fails()) {
    return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
    }

    $insert = [
    'kode_instalasi' =>$request->kode_instalasi,
    'customer_id' => $request->customer_id,
    'order' => Tanggal::tglNasional($request->order),
    'desa' => $request->desa,
    'alamat' => $request->alamat,
    'koordinate' => $request->koordinate,
    'package_id' => $request->package_id
    ];

    $installations = Installations::create($insert);
    return response()->json([
    'msg' => 'Register Permohonan dengan Kode Instalasi ' . $insert['kode_instalasi'] . ' berhasil disimpan'
    ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Installation $installation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Installation $installation)
    {
        //test
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Installation $installation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Installation $installation)
    {
        //
    }
}
