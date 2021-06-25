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

        $artikel = new Berita();

        $artikel->user_id = auth()->user()->id;
        $artikel->judul = $request->judul;
        $artikel->isi = $request->isi;

        $artikel->save();

        return response()->json("Artikel berhasil dibuat", 200);
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('berita.show', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required|string',
            'isi' => 'required',
        ]);

        $artikel = Berita::findOrFail($id);

        $artikel->user_id = auth()->user()->id;
        $artikel->judul = $request->judul;
        $artikel->isi = $request->isi;
        $artikel->save();

        return response()->json("Artikel berhasil diubah", 200);
    }

    public function delete($id)
    {
        $artikel = Berita::findOrFail($id);
        $artikel->delete();
        return response()->json('ok', 200);
    }

    public function update2(Request $request, $id)
    {

        $updateBerita = Berita::findOrFail($id);
        $date = date('H-i-s');
        $random = \Str::random(5);

        if ($request->file('gambar_berita')) {
            $request->file('gambar_berita')->move('upload/berita', $date . $random . $request->file('gambar_berita')->getClientOriginalName());
            $updateBerita->dokumentasi = $date . $random . $request->file('gambar_berita')->getClientOriginalName();
        }

        $updateBerita->save();

        return back();
    }
}
