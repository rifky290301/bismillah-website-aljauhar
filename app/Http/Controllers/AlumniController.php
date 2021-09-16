<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AlumniController extends Controller
{
    private $photo = "";
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
        $users = Alumni::latest()->get();
        $kamar = [];
        $tahunMasuk = [];

        foreach ($users as $user) {
            array_push($kamar, $user["no_kamar"]);
            array_push($tahunMasuk, $user["tahun_masuk"]);
        }
        $kamar = array_unique($kamar);
        $tahunMasuk = array_unique($tahunMasuk);

        $kamar_ukniq = [];
        $tahun_ukniq = [];

        foreach ($kamar as $no) {
            $tes["index"] = $no;
            array_push($kamar_ukniq, $tes);
        }

        foreach ($tahunMasuk as $no) {
            $temp["index"] = $no;
            array_push($tahun_ukniq, $temp);
        }

        if (auth()->user()->hasRole("Super admin")) {
            $idRole = 1;
        } elseif (auth()->user()->hasRole("BPH")) {
            $idRole = 2;
        } else {
            $idRole = 3;
        }
        return response()->json([
            'users' => $users,
            'idRole' => $idRole,
            'kamar' => $kamar_ukniq,
            'tahun_masuk' => $tahun_ukniq
        ], 200);
    }


    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'nama' => 'required',
        //     'tahun_masuk' => 'required|number',
        //     'photo' => 'required|string|max:191|min:1',
        // ]);

        $alumni = new Alumni();

        $alumni->nama = $request->nama;
        $alumni->tahun_masuk = $request->tahun_masuk;
        $alumni->tahun_keluar = $request->tahun_keluar;
        $alumni->no_hp = $request->no_hp;
        $alumni->no_kamar = $request->no_kamar;
        $alumni->pekerjaan = $request->pekerjaan;
        $alumni->status = $request->status;
        $alumni->motto = $request->motto;
        if ($this->photo) {
            $alumni->photo = $this->photo;
            // $this->photo = "";
        }

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
        if ($request->photo != null) {
            $alumni->photo = $request->photo;
        }

        $alumni->save();
        return response()->json('ok', 200);
    }

    public function delete($id)
    {
        $alumni = Alumni::findOrFail($id);
        $path = public_path("upload/alumni/") . $alumni->photo;
        if (File::exists($path)) {
            unlink($path);
        }
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

    public function searchKamar(Request $request)
    {
        $searchWord = $request->get('s');
        $alumni = Alumni::where(function ($query) use ($searchWord) {
            $query->where('no_kamar', '=', $searchWord);
        })->latest()->get();

        return response()->json([
            'users' => $alumni
        ], 200);
    }

    public function searchTahun(Request $request)
    {
        $searchWord = $request->get('s');
        $alumni = Alumni::where(function ($query) use ($searchWord) {
            $query->where('tahun_masuk', '=', $searchWord);
        })->latest()->get();

        return response()->json([
            'users' => $alumni
        ], 200);
    }

    public function upload(Request $request, $id)
    {
        $date = date('H-i-s');
        $random = \Str::random(5);
        $alumni = Alumni::findOrFail($id);
        $path = public_path("upload/alumni/") . $alumni->photo;
        if (File::exists($path)) {
            unlink($path);
        }
        $request->file('photo')->move('upload/alumni', $date . $random . $request->file('photo')->getClientOriginalName());
        $alumni->photo = $date . $random . $request->file('photo')->getClientOriginalName();
        // return $name;
        $alumni->save();
    }
}
