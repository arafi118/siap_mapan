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
        $customer = Customer::with('village')->orderBy('id', 'ASC')->get();
        $title = 'Register Proposal'; 
        return view('perguliran.create')->with(compact('paket','installations','customer','title'));
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
    'customer_id',
    'order',
    'desa',
    'hamlet_id',
    'alamat',
    'koordinate',
    'package_id'
    ]);
    $rules = [
    'customer_id' => 'required',
    'order' => 'required',
    'desa' => 'required',
    'hamlet_id' => 'required',
    'alamat' => 'required',
    'koordinate'=> 'required',
    'package_id' => 'required'
    ];

    $validate = Validator::make($data,$rules);

    if ($validate->fails()) {
    return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
    }

    $insert = [
    'customer_id' => $request->customer_id,
    'order' => Tanggal::tglNasional($request->order),
    'desa' => $request->desa,
    'hamlet_id' => $request->hamlet_id,
    'alamat' => $request->alamat,
    'koordinate' => $request->koordinate,
    'package_id' => $request->package_id
    ];

    $installations = Installations::create($insert);
    return response()->json([
    'msg' => 'Register Permohonan dengan Kode Instalasi ' . $insert['customer_id'] . ' berhasil disimpan'
    ], Response::HTTP_ACCEPTED);
    }


    public function generatekode_istalasi()
    {
    $kd_desa = request()->get('kode_istalasi');

    $jumlah_instalasi_by_kd_desa = Installations::where('villages', $kd_desa)->orderBy('kd_instalasi', 'DESC');
    if ($jumlah_instalasi_by_kd_desa->count() > 0) {
        $data_instalasi = $jumlah_instalasi_by_kd_desa->first();
        $kode_istalasi= explode('-',$data_instalasi->kd_instalasi);

    if (count($kode_istalasi) >= 2) {
            $kode_istalasi = $kode_istalasi[0] . '-' . str_pad(($kode_istalasi[1] + 1), 3, "0", STR_PAD_LEFT);
        } else {
            $jumlah_instalasi = str_pad(Installations::where('villages', $kd_desa)->count() + 1, 3, "0", STR_PAD_LEFT);
            $kd_instalasi = $kd_desa . '-' . $jumlah_instalasi;
        }
        } else {
            $jumlah_instalasi = str_pad(Installations::where('desa', $kd_desa)->count() + 1, 3, "0", STR_PAD_LEFT);
            $kd_instalasi = $kd_desa . '-' . $jumlah_instalasi;
    
        }

    if (request()->get('kd_instalasi')) {
        $kd_kel = request()->get('kd_instalasi');
        $istallations = Installations::where('kd_instalasi', $kd_kel);
            if ($istallations->count() > 0) {
                $data_kel = $istallations->first();

                if ($kd_desa == $data_kel->desa) {
                    $kd_instalasi = $data_kel->kd_instalasi;
                }
            }
        }

        return response()->json([
            'kd_instalasi' => $kd_instalasi
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
        //
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
