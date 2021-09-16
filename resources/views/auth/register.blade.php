@extends('layouts.app')

@section('content')
  <!-- /.login-logo -->
<div class="card">
    <div class="login-logo pt-3">
        <a href="{{ url('/') }}">
            <img src="{{asset('assets/images/logoweb.png')}}" alt="Logo Al Jauhar" srcset="">
        </a>
    </div>
    <div class="card-body login-card-body">
        <p class="login-box-msg"> <b> Registrasi </b></p>

        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input id="name" type="text" placeholder="Nama" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>                <div class="input-group-append">
                    <div class="input-group-text">
                    </div>
                </div>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                    </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="input-group mb-3">
                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <div class="input-group-append">
                    <div class="input-group-text">
                    </div>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <input id="password-confirm" type="password" placeholder="Konfirmasi Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                <div class="input-group-append">
                    <div class="input-group-text">
                    </div>
                </div>
            </div>


            <div class="input-group mb-3">
                <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </div>
        </form>
        <p class="mb-0">
            <a href="{{route('login')}}" class="text-center">Sudah memiliki akun?</a>
        </p>
    </div>
    <!-- /.Register-card-body -->
</div>


@endsection
