@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Data Target</h4>
                <div>
                    <a href="{{ route('target.create') }}" class="btn btn-sm btn-success">Tambah Target</a>
                </div>
            </div>
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
            @elseif($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
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

            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Nama Target</th>
                            <th>Url</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($target as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->url }}</td>
                                <td>
                                    <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-1">
                                        <a href="{{ route('target.show', $item->id) }}"
                                            class="btn btn-sm btn-primary text-white">Detail Target</a>
                                        <form method="POST" action="{{ route('scrape', $item->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning text-white">Scrape</button>
                                        </form>
                                        <a href="{{ route('result.index', $item->id) }}"
                                            class="btn btn-sm btn-success text-white">Hasil Scrape</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#dataTable');
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-scrape').click(function() {
                var itemId = $(this).attr('data_value')

                $('#scrapeForm').attr('action', 'scrape/' + itemId)
            })
        })
    </script>
@endpush
