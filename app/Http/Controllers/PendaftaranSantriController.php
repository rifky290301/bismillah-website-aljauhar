<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSantri;
use Illuminate\Http\Request;

class PendaftaranSantriController extends Controller
{
    public function index()
    {
        return view('pendaftaran-santri.index');
    }

    public function getAll()
    {

        $pendaftaranSantri = PendaftaranSantri::latest()->get();

        return response()->json([
            'pendaftaranSantri' => $pendaftaranSantri,
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required',
            'status' => 'required',
            'tempat_status' => 'required',
            'orang_tua_wali' => 'required',
            'pekerjaan_orang_tua_wali' => 'required',
            'alamat' => 'required',
            'desa_kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten_kota' => 'required',
            'kodepos' => 'required',
            'no_telepon' => 'required',
            'no_telepon_keluarga' => 'required',
            'ukuran_jas_almamater' => 'required',
        ]);
        $newPendaftar = new PendaftaranSantri();
        $newPendaftar->nama_lengkap = $request->nama_lengkap;
        $newPendaftar->nama_panggilan = $request->nama_panggilan;
        $newPendaftar->tempat_lahir = $request->tempat_lahir;
        $newPendaftar->tanggal_lahir = $request->tanggal_lahir;
        $newPendaftar->email = $request->email;
        $newPendaftar->status = $request->status;
        $newPendaftar->tempat_status = $request->tempat_status;
        $newPendaftar->orang_tua_wali = $request->orang_tua_wali;
        $newPendaftar->pekerjaan_orang_tua_wali = $request->pekerjaan_orang_tua_wali;
        $newPendaftar->alamat = $request->alamat;
        $newPendaftar->desa_kelurahan = $request->desa_kelurahan;
        $newPendaftar->kecamatan = $request->kecamatan;
        $newPendaftar->kabupaten_kota = $request->kabupaten_kota;
        $newPendaftar->kodepos = $request->kodepos;
        $newPendaftar->no_telepon = $request->no_telepon;
        $newPendaftar->no_telepon_keluarga = $request->no_telepon_keluarga;
        $newPendaftar->ukuran_jas_almamater = $request->ukuran_jas_almamater;

        $date = date('H-i-s');
        $random = \Str::random(5);

        if ($request->file('pas_foto')) {
            $request->file('pas_foto')->move('upload/pendaftar', $date . $random . $request->file('pas_foto')->getClientOriginalName());
            $newPendaftar->pas_foto = $date . $random . $request->file('pas_foto')->getClientOriginalName();
        }

        if ($request->file('bukti_pembayaran')) {
            $request->file('bukti_pembayaran')->move('upload/pembayaran', $date . $random . $request->file('bukti_pembayaran')->getClientOriginalName());
            $newPendaftar->bukti_pembayaran = $date . $random . $request->file('bukti_pembayaran')->getClientOriginalName();
        }

        $newPendaftar->save();

        return back();
    }


    public function delete($id)
    {
        $pendaftar = PendaftaranSantri::findOrFail($id);
        $pendaftar->delete();
        return response()->json('ok', 200);
    }
}
