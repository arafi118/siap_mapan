<?php

namespace App\Http\Controllers;

use App\Models\Installations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $registerUnpaid = Installations::where('status', '0')->count();
        $registerPaid = Installations::where('status', 'R')->count();

        Session::put('business_id', '1');
        return view('welcome')->with('title', 'Dashboard');
    }
}
