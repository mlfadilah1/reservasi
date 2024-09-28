@extends('admin.app')
@section('title', 'Daftar Menu | Sundaa Coffee')
@section('js')
    <script src="sweetalert2.min.js"></script>

    <script>
        $(function() {
            $(document).on('click', '.delete-button', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                Swal.fire({
                    title: "Apakah anda yakin menghapus data ini?",
                    text: "Anda tidak akan dapat mengembalikan data ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Saya Yakin!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            })
        })
    </script>
@endsection
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
                    <h5 class="card-title fw-semibold mb-4">Menu</h5>
                    <a href="{{ url('tambahmenu') }}" class="btn btn-primary mb-3">
                        <i class="ti ti-plus"></i> Tambah Menu
                    </a>
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Menu</th>
                                            <th>Deskripsi</th>
                                            <th>Harga</th>
                                            <th>Kategori</th>
                                            <th>Foto</th>
                                            <th>Stok</th>
                                            <th>Jumlah Pesanan</th> <!-- Kolom baru untuk total pesanan -->
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @if ($menu)
                                            @foreach ($menu as $data)
                                                <tr>
                                                    <th scope="row">{{ $no++ }}</th>
                                                    <td>{{ $data->nama_menu }}</td>
                                                    <td>{{ $data->deskripsi }}</td>
                                                    <td>Rp. {{ number_format($data->harga) }}</td>
                                                    <td>{{ $data->kategori }}</td>
                                                    <td>
                                                        <img width="100" height="100" src="{{ url('storage/menu/' . $data->foto) }}" alt="Menu Image">
                                                    </td>
                                                    <td>{{ $data->stok }}</td>
                                                    <td>{{ $data->total_orders ?? 0 }}</td> <!-- Menampilkan jumlah pesanan, default 0 jika tidak ada -->
                                                    <td class="text-center">
                                                        <!-- Dropdown untuk Edit dan Hapus -->
                                                        <div class="dropdown">
                                                            <button class="btn btn-light ti ti-dots-vertical" type="button"
                                                                id="menuOptions" data-bs-toggle="dropdown" aria-expanded="false"
                                                                style="border: none; background: none;">
                                                                <i class="ti ti-more" style="font-size: 1.5rem;"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="menuOptions">
                                                                <li>
                                                                    <a href="{{ url('editmenu/' . $data->id_menu) }}" class="dropdown-item">
                                                                        <i class="ti ti-pencil"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ url('deletemenu/' . $data->id_menu) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger">
                                                                            <i class="ti ti-trash"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
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
