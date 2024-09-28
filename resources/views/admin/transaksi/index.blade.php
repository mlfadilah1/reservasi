@extends('admin.app')
@section('title', 'Transaksi | Sunda Coffee')
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Transaksi</h5>
                {{-- <a href="{{ url('tambahtransaksi') }}" class="btn btn-primary mb-3">
                    <i class="ti ti-plus"></i> Tambah Transaksi
                </a> --}}
                <div class="card">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Meja</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah Tamu</th>
                                        <th>Total Harga</th>
                                        <th>Status</th> <!-- Kolom Status -->
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @if ($reservasi)
                                        @foreach ($reservasi as $data)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $data->no_meja }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->tanggal }}</td>
                                                <td>{{ $data->jumlah_tamu }}</td>
                                                <td>{{ number_format($data->total_harga, 0, ',', '.') }}</td>

                                                <!-- Kolom Status dengan Dropdown -->
                                                <td>
                                                    <form action="{{ route('updatereservasi', $data->id_reservasi) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <select name="status" class="form-select"
                                                            onchange="this.form.submit()">
                                                            <option value="Belum Selesai"
                                                                {{ $data->status == 'Belum Selesai' ? 'selected' : '' }}>
                                                                Belum Selesai</option>
                                                            <option value="Selesai"
                                                                {{ $data->status == 'Selesai' ? 'selected' : '' }}>Selesai
                                                            </option>
                                                        </select>
                                                    </form>
                                                </td>

                                                <!-- Kolom Aksi -->
                                                {{-- <td>
                                                    <!-- Tombol Edit -->
                                                    <a href="{{ url('edit/' . $data->id_reservasi) }}" class="btn btn-sm btn-warning">
                                                        <i class="ti ti-pencil"></i> Edit
                                                    </a>
                                                    
                                                    <!-- Tombol Hapus dengan konfirmasi -->
                                                    <form action="{{ url('hapusreservasi/' . $data->id_reservasi) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger delete-button" onclick="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')">
                                                            <i class="ti ti-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td> --}}
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

@endsection
