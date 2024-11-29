<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SopController extends Controller
{
    public function index()
    {
        $title = 'Sop';
        return view('sop.index')->with(compact('title'));
    }
}
