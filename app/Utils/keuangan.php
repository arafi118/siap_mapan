<?php

namespace App\Utils;

use App\Models\Account;
use App\Models\AkunLevel2;
use App\Models\Amount;
use App\Models\Business;
use App\Models\Kecamatan;
use App\Models\PinjamanKelompok;
use App\Models\Rekening;
use App\Models\Saldo;
use App\Models\Transaction;
use App\Models\Transaksi;
use DB;
use Session;

class Keuangan
{
    function ProsSaldo($bulan_kemarin, $bulan_sekarang)
    {
        if ($bulan_kemarin == 0) {
            if ($bulan_sekarang > 0) {
                return 100;
            } else {
                return 0;
            }
        }

        if ($bulan_sekarang == 0) {
            return -100;
        }

        $percentageChange = (($bulan_sekarang - $bulan_kemarin) / $bulan_kemarin) * 100;
        return $percentageChange;
    }
}
