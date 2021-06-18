<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
// use App\Models\User;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('alumni.index');
    }

    public function getAll()
    {
        // dd("tes");
        $users = Alumni::latest()->get();
        return response()->json([
            'users' => $users
        ], 200);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'tahun_masuk' => 'required',
        ]);

        $alumni = new Alumni();

        $alumni->nama = $request->nama;
        $alumni->tahun_masuk = $request->tahun_masuk;
        $alumni->tahun_keluar = $request->tahun_keluar;
        $alumni->no_hp = $request->no_hp;
        $alumni->no_kamar = $request->no_kamar;

        $alumni->save();

        return response()->json("User Created", 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'tahun_masuk' => 'required',
        ]);

        $alumni = Alumni::findOrFail($id);

        $alumni->nama = $request->nama;
        $alumni->tahun_masuk = $request->tahun_masuk;
        $alumni->tahun_keluar = $request->tahun_keluar;
        $alumni->no_hp = $request->no_hp;
        $alumni->no_kamar = $request->no_kamar;


        $alumni->save();

        return response()->json('ok', 200);
    }


    public function delete($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();
        return response()->json('ok', 200);
    }

    public function search(Request $request)
    {
        $searchWord = $request->get('s');
        $alumni = Alumni::where(function ($query) use ($searchWord) {
            $query->where('nama', 'LIKE', "%$searchWord%");
        })->latest()->get();

        return response()->json([
            'users' => $alumni
        ], 200);
    }
}
