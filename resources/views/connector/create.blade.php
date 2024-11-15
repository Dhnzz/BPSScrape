@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambah Data Target</h5>
            <form method="POST" action="{{ route('target.store') }}" class="" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Nama Web</label>
                    <input type="text" placeholder="Masukkan nama web target..."
                        class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" name="name">
                    @error('name')
                        <small class="invalid-feedback">
                            {{$message}}
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">URL Web<span class="text-danger">*</span></label>
                    <input type="text" placeholder="Masukkan nama web target..."
                        class="form-control @error('url') is-invalid @enderror" value="{{old('url')}}" name="url">
                        <small class="text-danger">Masukkan alamat pencarian, lalu ganti keyword pencarian dengan kata keyword : https://www.hulondalo.id/search?q=<strong class="fw-bold">bps</strong> >> https://www.hulondalo.id/search?q=<strong class="fw-bold">keyword</strong></small>
                    @error('url')
                        <small class="invalid-feedback">
                            {{$message}}
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Keyword Connector<span class="text-danger">*</span></label>
                    <input type="text" placeholder="Masukkan connector keyword target..."
                        class="form-control @error('connector') is-invalid @enderror" value="{{old('connector')}}" name="connector">
                        <small class="text-danger">Masukkan penyambung unik dari target</small>
                    @error('connector')
                        <small class="invalid-feedback">
                            {{$message}}
                        </small>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-success btn-icon-split">
                        <span class="icon text-white"><i class="fa-solid fa-floppy-disk"></i></span>
                        <span class="text">Simpan</span>
                    </button>
                    <button type="reset" class="btn btn-warning btn-icon-split">
                        <span class="icon"><i class="fa-solid fa-repeat"></i></span>
                        <span class="text">Reset</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
