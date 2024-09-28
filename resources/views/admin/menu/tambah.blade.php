@extends('admin.app')
@section('title','Tambah Daftar Menu | Sundaa Coffee')
@section('content')
<br>
<br>
<br>
<br>
<br>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Tambah Menu</h5>
                <div class="card">
                    <div class="container-fluid">
                        <form action="{{ route('submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="nama_menu" class="form-label">Nama Menu</label>
                                <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" required>
                            </div>
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-control" id="kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Manual Brew">Manual Brew</option>
                                    <option value="Makan Berat">Makan Berat</option>
                                    <option value="Desert"> Desert</option>
                                    <option value="Non Coffee"> Non Coffee</option>
                                    <option value="Coffee">Coffee</option>
                                    <option value="Extra Toping">Extra Toping</option>
                                    <option value="Cemilan">Cemilan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*"
                                    required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('menu') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
