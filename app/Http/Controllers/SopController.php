<?php

namespace App\Http\Controllers;

use App\Models\Sop;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

class SopController extends Controller
{
    public function index()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $settings = Settings::all();

        $tampil_settings = $pengaturan->first();
        $title = 'Personalisasi Sop';
        return view('sop.index')->with(compact('title', 'settings', 'tampil_settings'));
    }

    public function profil()
    {
        $title = 'Sop';

        return view('sop.partials.profil')->with(compact('title'));
    }

    public function pasang_baru()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        if (request()->ajax()) {
            $data['swit_tombol'] = request()->get('swit_tombol');
            $data['pasang_baru'] = request()->get('pasang_baru');
            $data['abodemen'] = request()->get('abodemen');
            $data['denda'] = request()->get('denda');

            $validate = Validator::make($data, [
                'swit_tombol' => 'required',
                'pasang_baru' => 'required',
                'abodemen'    => 'required',
                'denda'       => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
            }

            $data['pasang_baru'] = str_replace(',', '', $data['pasang_baru']);
            $data['pasang_baru'] = str_replace('.00', '', $data['pasang_baru']);
            $data['pasang_baru'] = floatval($data['pasang_baru']);

            $data['abodemen'] = str_replace(',', '', $data['abodemen']);
            $data['abodemen'] = str_replace('.00', '', $data['abodemen']);
            $data['abodemen'] = floatval($data['abodemen']);

            $data['denda'] = str_replace(',', '', $data['denda']);
            $data['denda'] = str_replace('.00', '', $data['denda']);
            $data['denda'] = floatval($data['denda']);

            $pasang_baru = $data['pasang_baru'];
            $abodemen    = $data['abodemen'];
            $denda       = $data['denda'];

            if ($pengaturan->count() > 0) {
                $Settings = $pengaturan->update([
                    'swit_tombol' => $data['swit_tombol'],
                    'pasang_baru' => $pasang_baru,
                    'abodemen'    => $abodemen,
                    'denda'       => $denda,
                ]);
            } else {
                $Settings = Settings::create([
                    'business_id' => $business_id,
                    'swit_tombol' => $data['swit_tombol'],
                    'pasang_baru' => $pasang_baru,
                    'abodemen'    => $abodemen,
                    'denda'       => $denda,
                ]);
            }

            return response()->json([
                'success' => true,
                'Settings' => $Settings
            ], Response::HTTP_ACCEPTED);
        }

        $tampil_settings = $pengaturan->first();
        $title = 'Sop';
        return view('sop.partials.pasang_baru')->with(compact('title', 'tampil_settings'));
    }

    public function block_paket()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        if (request()->ajax()) {

            $nama = request()->get('nama');
            $jarak = request()->get('jarak');

            $blok = [];
            for ($i = 0; $i < count($nama); $i++) {
                if ($nama[$i] == '' or $jarak[$i] == '') {
                    continue;
                }

                $blok[] = [
                    "nama" => $nama[$i],
                    "jarak" => $jarak[$i]
                ];
            }

            if ($pengaturan->count() > 0) {
                $Settings = $pengaturan->update([
                    'block' => json_encode($blok),
                ]);
            } else {
                $Settings = Settings::create([
                    'business_id' => $business_id,
                    'block' => json_encode($blok),
                ]);
            }

            return response()->json([
                'success' => true,
                'simpanpblock' => $Settings
            ]);
        }

        $tampil_settings = $pengaturan->first();
        $title = 'Sop';
        return view('sop.partials.block_paket')->with(compact('title', 'tampil_settings'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $Settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $Settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Settings $Settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $Settings)
    {
        //
    }
}
