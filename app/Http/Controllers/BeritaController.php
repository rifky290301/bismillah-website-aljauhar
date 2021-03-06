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

        $berita = Berita::findOrFail($id);
        $berita->judul = $request->judul;
        $berita->isi = $request->isi;
        $berita->publish = $request->publish;
        $berita->save();

        return response()->json("Artikel berhasil diubah", 200);
    }

    public function delete($id)
    {
        $berita = Berita::findOrFail($id);
        $path = public_path("upload/berita/") . $berita->dokumentasi;
        try {
            unlink($path);
        } catch (\Throwable $th) {
        } finally {
            $berita->delete();
        }
        return response()->json('ok', 200);
    }

    public function upload(Request $request, $id)
    {
        $date = date('H-i-s');
        $random = \Str::random(5);
        $berita = Berita::findOrFail($id);
        $path = public_path("upload/berita/") . $berita->dokumentasi;
        try {
            unlink($path);
        } catch (\Throwable $th) {
        } finally {
            $request->file('photo')->move('upload/berita', $date . $random . $request->file('photo')->getClientOriginalName());
            $berita->dokumentasi = $date . $random . $request->file('photo')->getClientOriginalName();
            $berita->save();
        }
    }
}
