<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SopController extends Controller
{
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
