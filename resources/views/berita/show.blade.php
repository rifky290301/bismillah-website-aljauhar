@extends('layouts.admin')
@section('title')
Berita
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <form method="POST" action="/berita/show/{{$berita->id}}" enctype="multipart/form-data">
      @csrf
      <div class="card card-primary">
        <div class="card-header">
          {{$berita->judul}}
        </div>
        <div class="card-body">
          @isset($berita->dokumentasi)
            <img src="{{asset("upload/berita/$berita->dokumentasi")}}" class="img-fluid" alt="Responsive image">
          @endisset
            <div class="">
              {!! $berita->isi !!}
            </div>
          @if(!isset($berita->dokumentasi))
            <div class="form-group">
              <label for="gambar_berita">Pilih gambar erita</label><br>
              <input type="file" name="gambar_berita" id="gambar_berita" >
            </div>
          @endif
        </div>
        @if(!isset($berita->dokumentasi))
          <div class="card-footer">
            <button type="submit" class="btn btn-primary"> Submit</button>
          </div>
        @endif
      </div>
    
    </form>
  </div>
</div>

@endsection
