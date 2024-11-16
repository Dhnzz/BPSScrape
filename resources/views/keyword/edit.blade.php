@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Data Target</h5>
            <form method="POST" action="{{ route('keyword.update', $keyword->id) }}" class="" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Nama Web</label>
                    <input type="text" placeholder="Masukkan nama web target..."
                        class="form-control @error('keyword') is-invalid @enderror" name="keyword" value="{{$keyword->keyword}}">
                    @error('keyword')
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
