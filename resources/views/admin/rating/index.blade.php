@extends('admin.app')
@section('title','Daftar Rating | Sundaa Coffee')
@section('content')
<br>
<br>
<br>
<br>
<br>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Daftar Rating</h5>
                {{-- <a href="{{ url('tambahmenu') }}" class="ti ti-plus">Tambah Menu</a> --}}
                <div class="card">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table" class="display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pembeli</th>
                                        <th>Nama Menu</th>
                                        <th>Rating</th>
                                        <th>Ulasan</th>
                                        <th>foto</th>
                                        {{-- <th>Kategori</th>
                                        <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @if ($rating)
                                    @foreach ($rating as $data)
                                    <tr>
                                        <th scope="row">{{ $no++ }}</th>
                                        <th scope="row">{{ $data->name }}</th>
                                        <th scope="row">{{ $data->nama_menu }}</th>
                                        <th scope="row">{{ $data->bintang }}</th>
                                        <th scope="row">{{ $data->ulasan }}</th>
                                        {{-- <th scope="row">Rp. {{ number_format($data->harga) }}</th>
                                        <th scope="row">{{ $data->kategori }}</th> --}}
                                        <th scope="row"><img width="100" height="100"
                                                src="{{ url('storage/menu/' . $data->foto) }}"></th>
                                        {{-- <th scope="row">
                                            <a href="{{ url('edit' . $data->id_menu) }}">Edit</a>
                                            <form action="{{ url('deletemenu/' . $data->id_menu) }}" method="GET" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-button ti ti-trash"></button>
                                            </form>
                                        </th> --}}
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection