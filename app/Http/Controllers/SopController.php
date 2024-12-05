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
    public function sistem_instalasi()
    {
        $business_id = Session::get('business_id');
        $pengaturan = Settings::where('business_id', $business_id);

        if (request()->ajax()) {
            $data['swit_tombol'] = request()->get('swit_tombol');

            $validate = Validator::make($data, [
            'swit_tombol' => 'required',
            ]);

            if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
            }

            if ($pengaturan->count() > 0) {
                $Settings = $pengaturan->update([
                    'swit_tombol' => $data['swit_tombol'],
                ]);
            } else {
                $Settings = Settings::create([
                    'business_id' => $business_id,
                    'swit_tombol' => $data['swit_tombol'],
                ]);
            }

            return response()->json([
                'success' => true,
                'Settings' => $Settings
            ], Response::HTTP_ACCEPTED);
        }
        
        $pengaturan->first();
        $title = 'Sop';
        return view('sop.partials.sistem_instalasi')->with(compact('title', 'pengaturan'));
    } 

    public function profil()
    {
        $title = 'Sop';
        return view('sop.partials.profil')->with(compact('title'));
    }

    public function create_paket()
    {
        $title = 'Sop';
        return view('sop.partials.paket')->with(compact('title'));
    }

}
