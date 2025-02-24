<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Sop;
use App\Models\AkunLevel1;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

class SopController extends Controller
{
    public function index()
    {
        $api = env('APP_API', 'http://localhost:8080');
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);
        $business = Business::where('id', $business_id)->first();
        $token = $business->token;

        $tampil_settings = $pengaturan->first();
        $title = 'Personalisasi Sop';
        return view('sop.index')->with(compact('title', 'api', 'business', 'token', 'tampil_settings'));
    }

    public function profil()
    {
        $business_id = Session::get('business_id');

        $business = Business::where('id', $business_id)->first();

        $title = 'Sop';

        return view('sop.partials.profil')->with(compact('title', 'business'));
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
    public function coa()
    {
        $title = "Chart Of Account (CoA)";
        $akun1 = AkunLevel1::with([
            'akun2',
            'akun2.akun3',
            'akun2.akun3.accounts' 
            ])->get();

        return view('sop.partials.coa')->with(compact('title', 'akun1'));
    }
    public function lembaga()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Business::where('id', $business_id);
        $business = Business::all();

        if (request()->ajax()) {
            $data['nama'] = request()->get('nama');
            $data['alamat'] = request()->get('alamat');
            $data['telpon'] = request()->get('telpon');
            $data['email'] = request()->get('email');

            $validate = Validator::make($data, [
                'nama' => 'required',
                'alamat' => 'required',
                'telpon'    => 'required',
                'email'       => 'required'
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
            }

            if ($pengaturan->count() > 0) {
                $business = $pengaturan->update([
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'],
                    'telpon'    => $data['telpon'],
                    'email'       => $data['email'],
                ]);
            } else {
                $business = Business::create([
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'],
                    'telpon'    => $data['telpon'],
                    'email'       => $data['email'],
                ]);
            }

            return response()->json([
                'success' => true,
                'business' => $business
            ], Response::HTTP_ACCEPTED);
        }

        $tampil_settings = $pengaturan->first();
        $title = 'Sop';
        return view('sop.partials.lembaga')->with(compact('title', 'business', 'tampil_settings'));
    }

    public function sistem_instal()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        if (request()->ajax()) {
            $data['batas_tagihan'] = request()->get('batas_tagihan');

            $validate = Validator::make($data, [
                'batas_tagihan' => 'required',
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
            }

            if ($pengaturan->count() > 0) {
                $Settings = $pengaturan->update([
                    'batas_tagihan' => $data['batas_tagihan'],
                ]);
            } else {
                $Settings = Settings::create([
                    'business_id' => $business_id,
                    'batas_tagihan' => $data['batas_tagihan']
                ]);
            }

            return response()->json([
                'success' => true,
                'Settings' => $Settings
            ], Response::HTTP_ACCEPTED);
        }

        $tampil_settings = $pengaturan->first();
        $title = 'Sop';
        return view('sop.partials.sistem_instal')->with(compact('title', 'tampil_settings'));
    }

    public function pesan(Request $request)
    {
        $business_id = Session::get('business_id');

        Settings::where('business_id', $business_id)->update([
            'pesan_tagihan' => $request->tagihan,
            'pesan_pembayaran' => $request->pembayaran,
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Pesan whatsapp berhasil diubah'
        ]);
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
