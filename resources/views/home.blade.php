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
                <p>Santri Aktif</p>
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
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$jumlah_registrasi}}</h3>
                <p>User Registrations</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="{{route("pendaftaran.santri")}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
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
    <!-- ./col -->
    <div class="col-md-3">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Collapsable</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            The body of the card
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
</div>
@endsection
