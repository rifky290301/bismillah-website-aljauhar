<?php

namespace App\Http\Controllers;

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
            $idRole = 3;
            $artikels = Artikel::with("user")->latest()->get();
        } else {
            $id = auth()->user()->id;
            $artikels = Artikel::where('user_id', "=", $id)->with("user")->latest()->get();
            $idRole = 1;
        }
        return response()->json([
            'artikels' => $artikels,
            'idRole' => $idRole
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
        if (auth()->user()->hasRole('Super admin') || auth()->user()->hasRole('BPH')) {
            $artikel->publish = $request->publish;
        } else {
            $artikel->publish = 'not';
        }
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

        $artikel->judul = $request->judul;
        $artikel->isi = $request->isi;
        if (auth()->user()->hasRole('Super admin') || auth()->user()->hasRole('BPH')) {
            $artikel->publish = $request->publish;
        }
        $artikel->publish = $request->publish;
        $artikel->save();

        return response()->json("Artikel berhasil diubah", 200);
    }

    public function delete($id)
    {
        $artikel = Artikel::findOrFail($id);
        $path = public_path("upload/gambar-artikel/") . $artikel->gambar;
        try {
            unlink($path);
        } catch (\Throwable $th) {
        } finally {
            $artikel->delete();
        }
        return response()->json('ok', 200);
    }

    public function upload(Request $request, $id)
    {
        $date = date('H-i-s');
        $random = \Str::random(5);
        $artikel = Artikel::findOrFail($id);
        $path = public_path("upload/gambar-artikel/") . $artikel->gambar;
        try {
            unlink($path);
        } catch (\Throwable $th) {
        } finally {
            $request->file('photo')->move('upload/gambar-artikel', $date . $random . $request->file('photo')->getClientOriginalName());
            $artikel->gambar = $date . $random . $request->file('photo')->getClientOriginalName();
            $artikel->save();
        }
    }

    public function client()
    {
        $artikel = Artikel::latest()->get();
        return view('frontend.artikel', compact('artikel'));
    }
}
