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

            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Headline Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="form-control-plaintext text-wrap">{{ ($target->selector->headlines == null)?'Belum Memiliki Selector':$target->selector->headlines }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Date Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="form-control-plaintext text-wrap">{{ ($target->selector->date == null)?'Belum Memiliki Selector':$target->selector->date }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Link Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="form-control-plaintext text-wrap">{{ ($target->selector->link == null)?'Belum Memiliki Selector':$target->selector->link }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Content Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="form-control-plaintext text-wrap">{{ ($target->selector->content == null)?'Belum Memiliki Selector':$target->selector->content }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Cover Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="form-control-plaintext text-wrap">{{ ($target->selector->cover == null)?'Belum Memiliki Selector':$target->selector->cover }}</span>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="" class="col-sm-2 col-5 col-form-label">Tags Selector</label>
                <div class="col-auto col-form-label">
                    <span>:</span>
                </div>
                <div class="col-6">
                    <span class="form-control-plaintext text-wrap">{{ ($target->selector->tags == null)?'Belum Memiliki Selector':$target->selector->tags }}</span>
                </div>
            </div>
            <div>
                <a href="{{ route('target.addSelector', $target->id) }}" class="btn btn-success">Tambah Selector</a>
            </div>
        </div>
    </div>
@endsection
