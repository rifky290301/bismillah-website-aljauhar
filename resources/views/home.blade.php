@extends('layouts.admin')

@section('title')
Home
@endsection

@section('content')

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$jumlah_santri}}</h3>
                <p>Santri</p>
            </div>
            <div class="icon">
                <i class="fas fa-users-cog nav-icon"></i>
            </div>
            <a href="{{ route('user.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$jumlah_alumni}}</h3>
                <p>Alumni</p>
            </div>
            <div class="icon">
                <i class="fas fa-users nav-icon"></i>
            </div>
            <a href="/alumni" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    @can('melihat pendaftar')
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$jumlah_registrasi}}</h3>
                <p>Pendaftaran Santri</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="{{route("pendaftaran.santri")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @endcan
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$jumlah_artikel}}</h3>
                <p>Artikel</p>
            </div>
            <div class="icon">
                <i class="nav-icon fas fa-paste"></i>
            </div>
            <a href="{{route("artikel.index")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @can('membuat berita')
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{$jumlah_berita}}</h3>
                <p>Berita</p>
            </div>
            <div class="icon">
                <i class="fas fa-newspaper nav-icon"></i>
            </div>
            <a href="{{route("berita.index")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @endcan
    {{-- <dashboard></dashboard> --}}
</div>
@endsection
