<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index()
    {
        return view('santri.index');
    }

    public function getAll()
    {
        $santri = Santri::latest()->get();
        if (auth()->user()->hasRole("Super admin")) {
            $idRole = 1;
        } elseif (auth()->user()->hasRole("BPH")) {
            $idRole = 2;
        } else {
            $idRole = 3;
        }
        return response()->json([
            'santri' => $santri,
            'idRole' => $idRole,
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'no_hp' => 'required',
            'no_kamar' => 'required',
            'status' => 'required',
            'instansi' => 'required',
            // 'alamat' => 'required',
            'tahun_masuk' => 'required',
        ]);

        $santri = new Santri();

        $santri->nama = $request->nama;
        $santri->no_hp = $request->no_hp;
        $santri->no_kamar = $request->no_kamar;
        $santri->status = $request->status;
        $santri->instansi = $request->instansi;
        $santri->prodi = $request->prodi;
        $santri->alamat = $request->alamat;
        $santri->tahun_masuk = $request->tahun_masuk;

        $santri->save();

        return response()->json("User Created", 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'no_hp' => 'required',
            'no_kamar' => 'required',
            'status' => 'required',
            'instansi' => 'required',
            'tahun_masuk' => 'required',
        ]);

        $santri = Santri::findOrFail($id);

        $santri->nama = $request->nama;
        $santri->no_hp = $request->no_hp;
        $santri->no_kamar = $request->no_kamar;
        $santri->status = $request->status;
        $santri->instansi = $request->instansi;
        $santri->prodi = $request->prodi;
        $santri->alamat = $request->alamat;
        $santri->tahun_masuk = $request->tahun_masuk;

        $santri->save();
        return response()->json('ok', 200);
    }

    public function delete($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->delete();
        return response()->json('ok', 200);
    }

    public function upload(Request $request, $id)
    {
        $date = date('H-i-s');
        $random = \Str::random(5);
        $alumni = Santri::findOrFail($id);
        $request->file('photo')->move('upload/santri', $date . $random . $request->file('photo')->getClientOriginalName());
        $alumni->photo = $date . $random . $request->file('photo')->getClientOriginalName();
        // return $name;
        $alumni->save();
    }
}
