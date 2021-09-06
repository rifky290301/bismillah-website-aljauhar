<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Artikel;
use App\Models\Berita;
use App\Models\Biografi;
use App\Models\PendaftaranSantri;
use App\Models\Testimoni;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jumlah_santri = count(User::get());
        $jumlah_alumni = count(Alumni::get());
        $jumlah_registrasi = count(PendaftaranSantri::get());
        $jumlah_artikel = count(Artikel::get());
        $jumlah_berita = count(Berita::get());
        return view('home', compact("jumlah_santri", "jumlah_berita", "jumlah_alumni", "jumlah_registrasi", "jumlah_artikel"));
    }
    
    public function welcome()
    {
        $allBerita = Berita::where('publish', true)->latest()->get();
        $allTestimoni = Testimoni::where('publish', true)->latest()->get();
        $allBiografi = Biografi::where('publish', true)->latest()->get();
        return view('index', compact("allBerita", "allTestimoni", "allBiografi"));
    }
}
