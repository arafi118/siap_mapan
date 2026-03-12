<?php

namespace App\Services;

use App\Models\Settings;
use Session;

class UsageServices
{
    public function dataCreate($data, $title = 'Register Pemakaian'): array
    {
        $caterId = (isset($data['cater_id'])) ? $data['cater_id'] : auth()->user()->id;

        $business_id = Session::get('business_id');
        $cater_id = auth()->user()->jabatan == '1' ? $caterId : auth()->user()->id;
        $bulan = $data['bulan'] ?: date('d/m/Y');

        $settings = Settings::where('business_id', $business_id)->first();

        return [
            'settings' => $settings,
            'cater_id' => $cater_id,
            'title' => $title,
            'bulan' => $bulan,
        ];
    }
}
