<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        return view('berita.index');
    }

    public function getAll()
    {
        $beritas = Berita::latest()->get();

        for ($i = 0; $i < count($beritas); $i++) {
            $beritas[$i]["created_by"] =  User::findOrFail($beritas[$i]["user_id"])->name;
        }

        return response()->json([
            'beritas' => $beritas
        ], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string',
            'isi' => 'required',
        ]);

        $berita = new Berita();

        $berita->user_id = auth()->user()->id;
        $berita->judul = $request->judul;
        $berita->isi = $request->isi;

        $berita->save();

        return response()->json("Berita berhasil dibuat", 200);
    }
}
