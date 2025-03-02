@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Data Keyword</h4>
                <div>
                    <a href="{{ route('keyword.create') }}" class="btn btn-sm btn-success">Tambah Keyword</a>
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
            @endif

            <table class="table table-sm table-bordered" id="dataTable">
                <thead>
                    <tr class="text-center">
                        <th>No.</th>
                        <th>Keyword</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($keyword as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->keyword }}</td>
                            <td class="d-flex flex-row gap-2">
                                <a href="{{route('keyword.edit', $item->id)}}" class="btn btn-sm btn-warning text-white">Edit Keyword</a>
                                <form action="{{route('keyword.destroy', $item->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-white">Hapus Keyword</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Scrape data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="scrapeForm" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="keyword" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="floatingInput">Keyword</label>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
