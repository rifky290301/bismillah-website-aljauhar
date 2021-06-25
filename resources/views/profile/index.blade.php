@extends('layouts.admin')

@section('title')
Profile
@endsection

@section('content')
<section class="content">
    <div class="">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img style="width: 200px;" class="profile-user-img img-fluid img-circle" src="{{ asset("upload/profil/".$photo) }}" alt="{{ auth()->user()->name . ' Photo' }}">
                        </div>

                        <h3 class="profile-username text-center" style="text-transform: uppercase">{{ auth()->user()->name }} </h3>
                        {{--  <p class="text-muted text-center">{{ auth()->user()->role }}</p>  --}}
                        <p class="text-muted text-center">{{ auth()->user()->email }}</p>
                        <p class="text-muted text-center">{{ auth()->user()->phone }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div>

                            <div>
                                <form class="form-horizontal" method="POST" action="{{ route('user.postProfile') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name"  id="name" class="form-control @error('name') is-invalid @enderror" value="{{ auth()->user()->name }}" required placeholder="Name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <input type="email" name="email"  id="email" class="form-control @error('email') is-invalid @enderror" value="{{ auth()->user()->email }}" placeholder="E-mail Address">
                                                @error('siteemail')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number" value="{{ auth()->user()->phone }}" required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="no_kamar">Nomor Kamar</label>
                                                <input type="text" name="no_kamar" id="no_kamar" class="form-control @error('no_kamar') is-invalid @enderror" placeholder="Nomor Kamar" value="{{ auth()->user()->no_kamar }}" required>
                                                @error('no_kamar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="status">Status (kuliah/sekolah/kerja)</label>
                                                <input type="text" name="status" id="status" class="form-control @error('status') is-invalid @enderror" placeholder="Status" value="{{ auth()->user()->status }}" required>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="instansi">Instansi</label>
                                                <input type="text" name="instansi" id="instansi" class="form-control @error('instansi') is-invalid @enderror" placeholder="Instansi" value="{{ auth()->user()->instansi }}" required>
                                                @error('instansi')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="alamat">Alamat Rumah</label>
                                                <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat" value="{{ auth()->user()->alamat }}" required>
                                                @error('alamat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="tahun_masuk">Tahun masuk</label>
                                                <input type="date" name="tahun_masuk" id="tahun_masuk" class="form-control @error('tahun_masuk') is-invalid @enderror" placeholder="Tahun Masuk" value="{{ auth()->user()->tahun_masuk }}" required>
                                                @error('tahun_masuk')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-file">
                                                    <input name="photo" type="file" class="custom-file-input" id="customFile">
                                                    <label class="custom-file-label" for="customFile">Pilih Gambar update profile</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12">
                                            <div class="form-group button">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Update Profile</button>
                                                {{--  <a role="button" href="admin/index.html" class="bizwheel-btn theme-2">Login</a>  --}}
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
