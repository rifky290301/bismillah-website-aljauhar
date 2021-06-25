<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home Al-Jauhar</title>

        <!-- Fonts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body >
        <div class="container">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endif
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Registrasi santri baru</h3>
                        </div>
                        <form method="POST" action="{{route("pendaftaran-santri.store")}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama lengkap</label>
                                    <input type="text" name="nama_lengkap"  id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap">
                                    @error('nama_lengkap')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="nama_panggilan">Nama Panggilan</label>
                                    <input type="text" name="nama_panggilan"  id="nama_panggilan" class="form-control @error('nama_panggilan') is-invalid @enderror" value="{{ old('nama_panggilan') }}" required placeholder="Nama Panggilan">
                                    @error('nama_panggilan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir"  id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}" required placeholder="Tempat Lahir">
                                    @error('tempat_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir"  id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required placeholder="Tanggal Lahir">
                                    @error('tanggal_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email"  id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="custom-select " value="{{ old('status') }}" id="status">
                                        <option selected>Choose...</option>
                                        <option value="Sekolah">Sekolah</option>
                                        <option value="Kuliah">Kuliah</option>
                                        <option value="Kerja">Kerja</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="tempat_status">Lokasi instansi</label>
                                    <input type="text" name="tempat_status"  id="tempat_status" class="form-control @error('tempat_status') is-invalid @enderror" value="{{ old('tempat_status') }}" required placeholder="Lokasi instansi">
                                    @error('tempat_status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="orang_tua_wali">Orang Tua atau Wali</label>
                                    <input type="text" name="orang_tua_wali"  id="orang_tua_wali" class="form-control @error('orang_tua_wali') is-invalid @enderror" value="{{ old('orang_tua_wali') }}" required placeholder="Orang Tua atau Wali">
                                    @error('orang_tua_wali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="pekerjaan_orang_tua_wali">Pekerjaan Orang Tua atau Wali</label>
                                    <input type="text" name="pekerjaan_orang_tua_wali"  id="pekerjaan_orang_tua_wali" class="form-control @error('pekerjaan_orang_tua_wali') is-invalid @enderror" value="{{ old('pekerjaan_orang_tua_wali') }}" required placeholder="Pekerjaan Orang Tua atau Wali">
                                    @error('pekerjaan_orang_tua_wali')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" name="alamat"  id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" required placeholder="Alamat">
                                    @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="desa_kelurahan">Desa atau Kelurahan</label>
                                    <input type="text" name="desa_kelurahan"  id="desa_kelurahan" class="form-control @error('desa_kelurahan') is-invalid @enderror" value="{{ old('desa_kelurahan') }}" required placeholder="Desa atau Kelurahan">
                                    @error('desa_kelurahan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input type="text" name="kecamatan"  id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" value="{{ old('kecamatan') }}" required placeholder="Kecamatan">
                                    @error('kecamatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="kabupaten_kota">Kabupaten atau Kota</label>
                                    <input type="text" name="kabupaten_kota"  id="kabupaten_kota" class="form-control @error('kabupaten_kota') is-invalid @enderror" value="{{ old('kabupaten_kota') }}" required placeholder="kabupaten_kota">
                                    @error('kabupaten_kota')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="kodepos">Kodepos</label>
                                    <input type="text" name="kodepos"  id="kodepos" class="form-control @error('kodepos') is-invalid @enderror" value="{{ old('kodepos') }}" required placeholder="kodepos">
                                    @error('kodepos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="no_telepon">Nomor telepon</label>
                                    <input type="text" name="no_telepon"  id="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon') }}" required placeholder="no_telepon">
                                    @error('no_telepon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="no_telepon_keluarga">Nomor Telepon Keluarga</label>
                                    <input type="text" name="no_telepon_keluarga"  id="no_telepon_keluarga" class="form-control @error('no_telepon_keluarga') is-invalid @enderror" value="{{ old('no_telepon_keluarga') }}" required placeholder="no_telepon_keluarga">
                                    @error('no_telepon_keluarga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="ukuran_jas_almamater">Ukuran Jas Almamater</label>
                                    <select name="ukuran_jas_almamater" class="custom-select " value="{{ old('ukuan_jas_almamater') }}" id="ukuan_jas_almamater">
                                        <option selected>Choose...</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                        <option value="XXXL">XXXL</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pas_foto">Pas_foto Foto </label>
                                    <input type="file" name="pas_foto"  id="pas_foto" >
                                </div>
                                
                                <div class="form-group">
                                    <label for="bukti_pembayaran">Bukti Pembayaran</label>
                                    <input type="file" name="bukti_pembayaran"  id="bukti_pembayaran" >
                                </div>
                                
                   

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"> Regsitrasi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
        </div>
    </body>
</html>
