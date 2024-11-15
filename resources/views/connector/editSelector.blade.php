@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Target {{ $target->name }}</h5>
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

            <hr class="border border-3 opacity-75">

            <form action="{{ route('target.updateSelector', $target->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Headline Selector</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                    <div class="col-6">
                        <input type="text" name="headline" id="headline"
                            class="form-control @error('headline') is-invalid @enderror"
                            placeholder="Masukkan selector untuk headline berita..." value="{{ $target->selector->headline }}">
                        @error('headline')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Date Selector</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                    <div class="col-6">
                        <input type="text" name="date" id="date"
                            class="form-control @error('date') is-invalid @enderror"
                            placeholder="Masukkan selector untuk tanggal berita..." value="{{ $target->selector->date }}">
                        @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Link Selector</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                    <div class="col-6">
                        <input type="text" name="link" id="link"
                            class="form-control @error('link') is-invalid @enderror"
                            placeholder="Masukkan selector untuk link berita..." value="{{ $target->selector->link }}">
                        @error('link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Content Selector</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                    <div class="col-6">
                        <input type="text" name="content" id="content"
                            class="form-control @error('content') is-invalid @enderror"
                            placeholder="Masukkan selector untuk konten berita..." value="{{ $target->selector->content }}">
                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Cover Selector</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                    <div class="col-6">
                        <input type="text" name="cover" id="cover"
                            class="form-control @error('cover') is-invalid @enderror"
                            placeholder="Masukkan selector untuk cover berita..." value="{{ $target->selector->cover }}">
                        @error('cover')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-5 col-form-label">Tags Selector</label>
                    <div class="col-auto col-form-label">
                        <span>:</span>
                    </div>
                    <div class="col-6">
                        <input type="text" name="tag" id="tag"
                            class="form-control @error('tag') is-invalid @enderror"
                            placeholder="Masukkan selector untuk tag berita..." value="{{ $target->selector->tags }}">
                        @error('tag')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
