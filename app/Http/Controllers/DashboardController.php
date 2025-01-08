<?php

namespace App\Http\Controllers;

use App\Models\Installations;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        Session::put('business_id', '1');
        $Installation = Installations::count();
        $Usage = Usage::where('status', 'PAID')->count();
        $Tagihan = Usage::where('status', 'UNPAID')->count();

        $title = 'Dashboard';
        return view('welcome')->with(compact('Installation', 'Usage', 'Tagihan', 'title'));
    }
}
