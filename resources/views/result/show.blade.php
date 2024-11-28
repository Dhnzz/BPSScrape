@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Berita</h5>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ $message }}
                </div>
                <script>
                    var alertList = document.querySelectorAll(".alert");
                    alertList.forEach(function(alert) {
                        new bootstrap.Alert(alert);
                    });
                </script>
            @endif
            <div class="row">
                <div class="col">
                    @if (!$result->cover)
                        <div class="text-white bg-primary d-flex justify-content-center align-items-center"
                            style="width: 100%; height:200px">
                            <h1 class="text-uppercase fw-bold text-center">Gambar Tidak Tersedia</h1>
                        </div>
                    @else
                        <img src="{{ $result->cover }}" class="img-thumbnail" alt="">
                    @endif
                </div>
            </div>
            <div class="mt-5 row">
                <div class="col row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Headline Berita</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                    <div class="col-6">
                        <span class="form-control-plaintext text-wrap">{{ $result->headline }}</span>
                    </div>
                    <div class="col">
                        <a href="{{ $result->link }}" class="btn btn-sm btn-primary">Kunjungi Situs</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Tanggal Rilis</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                    <div class="col-6">
                        <span class="form-control-plaintext text-wrap">{{ $result->date }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Konten</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span class="form-control-plaintext text-wrap">{{ $result->content }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Tags</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                    <div class="col-6 row">
                        @foreach (json_decode($result->tags, true) as $item)
                            <div class="col-3">
                                <span
                                    class="text-center form-control-plaintext text-wrap bg-primary text-white p-1 rounded">{{ $item }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
