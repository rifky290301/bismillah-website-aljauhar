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
        $testimoni->pekerjaan = $request->pekerjaan;
        $testimoni->testimoni = $request->testimoni;

        $testimoni->save();

        return response()->json("Testimoni berhasil dibuat", 200);
    }

    public function getAll()
    {
        $testimoni = Testimoni::latest()->get();
        return response()->json([
            'testimoni' => $testimoni
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'testimoni' => 'required',
            'pekerjaan' => 'required',
        ]);

        $testimoni = Testimoni::findOrFail($id);

        $testimoni->nama = $request->nama;
        $testimoni->pekerjaan = $request->pekerjaan;
        $testimoni->testimoni = $request->testimoni;
        $testimoni->publish = $request->publish;
        $testimoni->save();

        return response()->json("Testimoni berhasil diubah", 200);
    }

    public function delete($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $path = public_path("upload/testimoni/") . $testimoni->photo;
        try {
            unlink($path);
        } catch (\Throwable $th) {
        } finally {
            $testimoni->delete();
        }
        return response()->json('ok', 200);
    }

    public function upload(Request $request, $id)
    {
        $date = date('H-i-s');
        $random = \Str::random(5);
        $testimoni = Testimoni::findOrFail($id);
        $path = public_path("upload/testimoni/") . $testimoni->photo;
        try {
            unlink($path);
        } catch (\Throwable $th) {
        } finally {
            $request->file('photo')->move('upload/testimoni', $date . $random . $request->file('photo')->getClientOriginalName());
            $testimoni->photo = $date . $random . $request->file('photo')->getClientOriginalName();
            $testimoni->save();
        }
    }
}
