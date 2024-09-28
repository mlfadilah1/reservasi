@extends('admin.app')
@section('title','Edit Daftar Meja | Sundaa Coffee')
@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Meja</h5>
                <div class="card">
                    <div class="container-fluid">
                        @foreach ($meja as $result)
                        <form action="{{ route('updatemeja',$result->id_meja) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="mb-3">
                                    <label for="id_meja" class="form-label">ID Meja</label>
                                    <input type="text" class="form-control" id="id_meja" name="nama_meja"
                                        value="{{ $result->id_meja }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="no_meja" class="form-label">No Meja</label>
                                    <input type="text" class="form-control" id="no_meja" name="no_meja"
                                        value="{{ $result->no_meja }}" required>
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $result->deskripsi }}</textarea>
                                </div> --}}
                                <div class="mb-3">
                                    <label for="kapasitas" class="form-label">Kapasitas</label>
                                    <input type="number" class="form-control" id="kapasitas" name="kapasitas"
                                        value="{{ $result->kapasitas }}" required>
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-control" id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Manual Brew"
                                            {{ $result->kategori == 'Manual Brew' ? 'selected' : '' }}>Manual Brew
                                        </option>
                                        <option value="Makan Berat"
                                            {{ $result->kategori == 'Makan Berat' ? 'selected' : '' }}>Makan Berat
                                        </option>
                                        <option value="Desert"
                                            {{ $result->kategori == 'Desert' ? 'selected' : '' }}>Desert
                                        </option>
                                        <option value="Non Coffee" {{ $result->kategori == 'Non Coffee' ? 'selected' : '' }}>
                                            Non Coffee</option>
                                        <option value="Coffee" {{ $result->kategori == 'Coffee' ? 'selected' : '' }}>
                                            Coffee</option>
                                        <option value="Extra Toping" {{ $result->kategori == 'Extra Toping' ? 'selected' : '' }}>
                                            Extra Toping</option>
                                        <option value="Cemilan" {{ $result->kategori == 'Cemilan' ? 'selected' : '' }}>
                                            Cemilan</option>
                                    </select>
                                </div> --}}
                                {{-- <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="hidden" name="old_foto" class="form-control" onchange="previewImage()"
                                        min="0" max="100" id="foto" value="{{ $result->foto }}" required>
                                    <input type="file" name="foto" class="form-control">
                                </div> --}}
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('meja') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary" id="submitmeja">Simpan Perubahan</button>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
