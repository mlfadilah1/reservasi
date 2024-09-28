@extends('admin.app')
@section('title','Tambah Meja | Sundaa Coffee')
@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Tambah Meja</h5>
                <div class="card">
                    <div class="container-fluid">
                        <form action="{{ route('submitmeja') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="nama-barang">No Meja</label>
                                <input type="text" class="form-control" name="no_meja" placeholder="No Meja..." required />
                            </div>
                            <div class="mb-3">
                                <label for="nama-barang">Kapasistas</label>
                                <input type="text" class="form-control" name="kapasitas" placeholder="Kapasitas..." required />
                            </div>
                            {{-- <div class="mb-3">
                                <label for="role">Role</label>
                                <input type="text" class="form-control" name="role" value="Kasir" readonly />
                            </div> --}}
                            {{-- <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password..." required />
                            </div> --}}
                            {{-- <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            </div> --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('meja') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
