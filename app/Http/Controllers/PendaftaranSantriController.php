<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSantri;
use Illuminate\Http\Request;

class PendaftaranSantriController extends Controller
{
    public function index()
    {
        return view('pendaftaran-santri.index');
    }



    public function store(Request $request)
    {
        PendaftaranSantri::create($request->all());
        return back();
    }
}
