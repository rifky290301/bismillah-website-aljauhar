<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        return view('testimoni.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'testimoni' => 'required',
        ]);

        $testimoni = new Testimoni();

        $testimoni->nama = $request->nama;
        $testimoni->testimoni = $request->testimoni;

        $testimoni->save();

        return response()->json("Testimoni berhasil dibuat", 200);
    }
}
