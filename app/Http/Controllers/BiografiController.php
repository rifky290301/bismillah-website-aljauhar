<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biografi;
use Illuminate\Http\Request;

class BiografiController extends Controller
{
    public function index()
    {
        return view('biografi.index');
    }

    public function getAll()
    {
        $biografis = Biografi::latest()->get();
        for ($i = 0; $i < count($biografis); $i++) {
            $biografis[$i]["created_by"] =  User::findOrFail($biografis[$i]["user_id"])->name;
        }
        return response()->json([
            'biografis' => $biografis
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'biografi' => 'required',
        ]);

        $biografi = new Biografi();

        $biografi->user_id = auth()->user()->id;
        $biografi->nama = $request->nama;
        $biografi->biografi = $request->biografi;

        $biografi->save();

        return response()->json("Biografi berhasil dibuat", 200);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'biografi' => 'required',
        ]);

        $biografi = Biografi::findOrFail($id);

        $biografi->nama = $request->nama;
        $biografi->biografi = $request->biografi;
        $biografi->save();

        return response()->json("Biografi berhasil diubah", 200);
    }

    public function delete($id)
    {
        $biografi = Biografi::findOrFail($id);
        $biografi->delete();
        return response()->json('ok', 200);
    }
}
