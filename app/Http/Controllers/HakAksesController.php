<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HakAksesController extends Controller
{
    public function index() 
    {
        $users = User::all();
        return view('hak_akses.index')->with(compact('users'));
    }

    public function hak_akses($id_user)
    {
        //
    }

    public function simpan(Request $request, $id_user)
    {
        //
    }
}
