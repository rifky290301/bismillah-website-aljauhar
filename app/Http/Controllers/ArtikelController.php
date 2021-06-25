<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        return view('artikel.index');
    }

    public function getAll()
    {
        if (auth()->user()->hasRole('Super admin') || auth()->user()->hasRole('BPH')) {
            $artikels = Artikel::latest()->get();
        } else {
            $id = auth()->user()->id;
            $artikels = Artikel::where('user_id', "=", $id)->latest()->get();
        }
        for ($i = 0; $i < count($artikels); $i++) {
            $artikels[$i]["created_by"] =  User::findOrFail($artikels[$i]["user_id"])->name;
        }

        return response()->json([
            'artikels' => $artikels
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string',
            'isi' => 'required',
        ]);

        $artikel = new Artikel();

        $artikel->user_id = auth()->user()->id;
        $artikel->judul = $request->judul;
        $artikel->isi = $request->isi;

        $artikel->save();

        return response()->json("Artikel berhasil dibuat", 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required|string',
            'isi' => 'required',
        ]);

        $artikel = Artikel::findOrFail($id);

        // $artikel->user_id = auth()->user()->id;
        $artikel->judul = $request->judul;
        $artikel->isi = $request->isi;
        $artikel->save();

        return response()->json("Artikel berhasil diubah", 200);
    }

    public function delete($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();
        return response()->json('ok', 200);
    }
}
