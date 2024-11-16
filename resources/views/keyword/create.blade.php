@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambah Data Keyword</h5>
            <form method="POST" action="{{ route('keyword.store') }}" class="" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Keyword</label>
                    <input type="text" placeholder="Masukkan keyword untuk target..."
                        class="form-control @error('name') is-invalid @enderror" value="{{old('keyword')}}" name="keyword">
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
