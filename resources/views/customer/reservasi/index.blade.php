@extends('customer.app')

@section('content')
    <section id="reservasi">
        <div class="container-fluid contact py-6 wow bounceInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="row g-0">
                    <div class="col-12">
                        <div class="text-center">
                            <small
                                class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Pesanan Menu</small>
                            <h1 class="display-5 mb-5">Apakah Ada Tambahan Lagi?</h1>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Update</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @if ($keranjang)
                                @foreach ($keranjang as $datadetail)
                                    <form action="{{ route('tambahorder', $datadetail->id_keranjang) }}" method="POST">
                                        @csrf
                                        @php
                                            $total = $datadetail->jumlah * $datadetail->harga;
                                        @endphp
                                        <tr>
                                            <input type="hidden" value="{{ $datadetail->id_keranjang }}" name="iddetail">
                                            <input type="hidden" value="{{ $datadetail->id_menu }}" name="idtanaman">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $datadetail->nama_menu }}</td>
                                            <td>{{ $datadetail->kategori }}</td>
                                            <td><input class="form-control" type="number" name="jumlah" value="{{ $datadetail->jumlah }}" ></td>
                                            <td>Rp. {{ number_format($total) }}</td>
                                            <td><button type="submit" class="btn btn-success">Tambah</button></td>
                                            <td><a class="btn btn-danger" href="{{ url('hapusorder/' . $datadetail->id_keranjang) }}">X</a></td>
                                        </tr>
                                    </form>
                                @endforeach
                            @endif
                        </tbody>
                        </table>
                        @csrf
                        @php
                            $total_akhir = 0;
                            $total_harga = $dtl;
                            foreach ($total_harga as $row) {
                                $harga = $row->total_harga;
                                $jml = $row->jumlah;
                                $total = $harga * $jml;
                                $total_akhir = $total_akhir + $total;
                            }
                        @endphp
                        <h3>Total Harga : Rp. {{ number_format($total_akhir) }}</h5>
                    </div>
                    <div class="col-12">
                        <div class="border-bottom border-primary bg-light py-5 px-4">
                            <div class="text-center">
                                <small
                                    class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Reservasi</small>
                                <h1 class="display-5 mb-5">Inputkan Informasi Dengan Data Asli Supaya Mudah Menghubungi</h1>
                            </div>
                            <form action="{{ route('submitreservasi') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4 form">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="text" class="form-control border-primary p-2" name="nama"
                                            placeholder="Nama" value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input type="tel" class="form-control border-primary p-2" name="no_hp"
                                            placeholder="Nomor Kontak Anda" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <select class="form-select border-primary p-2" name="id_meja" required>
                                            <option selected disabled>No Meja</option>
                                            @foreach ($mejas as $meja)
                                                <option value="{{ $meja->id_meja }}">{{ $meja->no_meja }} - Kapasitas:
                                                    {{ $meja->kapasitas }} orang</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input type="number" class="form-control border-primary p-2" name="jumlah_tamu"
                                            placeholder="Jumlah Tamu" required min="1">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input type="datetime-local" class="form-control border-primary p-2" name="tanggal"
                                            placeholder="Pilih Tanggal" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <input type="hidden" class="form-control border-primary p-2" name="total_harga"
                                            placeholder="Total Harga" value="{{$total_akhir}}" >
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill">Reservasi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
