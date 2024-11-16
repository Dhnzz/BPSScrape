@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Target {{ $target->name }}</h5>
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
            <div class="mb-2 mt-5 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Nama Target</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="form-control-plaintext text-wrap">{{ $target->name }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Alamat Target</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="form-control-plaintext text-wrap">{{ $target->url }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Penghubung Unik</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="form-control-plaintext text-wrap">{{ Str::replace('keyword', 'keyword1"'.$target->connector.'"keyword2', $target->url) }}</span>
                </div>
            </div>

            <div class="d-flex flex-row">
                <a href="{{ route('target.edit', $target->id) }}" class="btn btn-warning text-white mr-2">Edit Target</a>
                <form action="{{route('target.destroy', $target->id)}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger text-white">Hapus Target</button>
                </form>
            </div>
            
            <hr class="border border-3 opacity-75">

            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Headline Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span
                        class="form-control-plaintext text-wrap">{{ $target->selector->headline == null ? 'Belum Memiliki Selector' : $target->selector->headline }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Date Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span
                        class="form-control-plaintext text-wrap">{{ $target->selector->date == null ? 'Belum Memiliki Selector' : $target->selector->date }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Link Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span
                        class="form-control-plaintext text-wrap">{{ $target->selector->link == null ? 'Belum Memiliki Selector' : $target->selector->link }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Content Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span
                        class="form-control-plaintext text-wrap">{{ $target->selector->content == null ? 'Belum Memiliki Selector' : $target->selector->content }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Cover Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span
                        class="form-control-plaintext text-wrap">{{ $target->selector->cover == null ? 'Belum Memiliki Selector' : $target->selector->cover }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Tags Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span
                        class="form-control-plaintext text-wrap">{{ $target->selector->tags == null ? 'Belum Memiliki Selector' : $target->selector->tags }}</span>
                </div>
            </div>
            <div>
                <a href="{{ route('target.addSelector', $target->id) }}" class="btn btn-success">Tambah Selector</a>
                <a href="{{ route('target.editSelector', $target->id) }}" class="btn btn-warning text-white">Edit
                    Selector</a>
            </div>
        </div>
    </div>
@endsection
