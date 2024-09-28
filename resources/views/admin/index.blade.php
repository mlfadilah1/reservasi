@extends('admin.app')
@section('content')
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container-fluid">
    <div class="row">
        <!-- Laporan Reservasi -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body" align='center'>
                    <h5 class="card-title">LAPORAN RESERVASI</h5>
                    <h6>Terdapat <strong>{{ $reservationCount }}</strong> laporan reservasi dari semua pesanan.</h6>
                    <a href="laporanreservasi" class="btn btn-primary">Reservasi</a>
                </div>
            </div>
        </div>

        <!-- Laporan Harian -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body" align='center'>
                    <h5 class="card-title">LAPORAN RESERVASI / HARIAN</h5>
                    <h6>Terdapat <strong>{{ $reservationharianCount }}</strong> Laporan Reservasi Hari Ini.</h6>
                    <a href="laporanharian" class="btn btn-primary">Harian</a>
                </div>
            </div>
        </div>

        <!-- Transaksi -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body" align='center'>
                    <h5 class="card-title">Transaksi</h5>
                    <h6>Terdapat <strong>{{ $transaksiCount }}</strong> Semua pesanan online.</h6>
                    <a href="{{ url('transaksi') }}" class="btn btn-primary">Transaksi</a>
                </div>
            </div>
        </div>

        @if (Auth::user()->role == 'Admin')

        <!-- Menu -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body" align='center'>
                    <h5 class="card-title">MENU</h5>
                    <h6>Terdapat <strong>{{ $menuCount }}</strong> Menu yang tersedia di List Menu.</h6>
                    <a href="{{ url('menu') }}" class="btn btn-primary">Menu</a>
                </div>
            </div>
        </div>

        <!-- Data Pembeli -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body" align='center'>
                    <h5 class="card-title">Data Pembeli</h5>
                    <h6>Terdapat <strong>{{ $pembeliCount }}</strong> Data pembeli.</h6>
                    <a href="pembeli" class="btn btn-primary">Data Pembeli</a>
                </div>
            </div>
        </div>

        <!-- Most Popular Menus -->
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title" align='center'>Menu Terlaris</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Nama Menu</th>
                                <th>Jumlah Pesanan</th>
                                <th>Aksi</th>
                                {{-- <th>Rata-rata Rating</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mostPopularMenus as $menu)
                                <tr>
                                    <td>{{ $menu->kategori }}</td>
                                    <td>{{ $menu->nama_menu }}</td>
                                    <td>{{ $menu->jumlah }} kali dipesan</td>
                                    <td>
                                        <button class="btn btn-secondary">
                                            <a class="dropdown-item edit" id="{{ $menu->id_menu }}" href="#">Detail</a>
                                        </button> 
                                    </td>
                                    {{-- <td>{{ number_format($menu->ratings_avg_rating, 1) }} bintang</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="modal-detailmenu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" >Detail Menu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="loaddetail">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Simpan</button> --}}
            </div>
        </div>
    </div>
</div>

@endsection
@push('myscript')
<script>
    $(function() {
        $(".edit").click(function() {
            let id = $(this).attr('id');
            $.ajax({
                type: 'GET'
                , url: `detailmenu/${id}`
                , cache: false
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id: id
                }
                , success: function(respond) {
                    $("#loaddetail").html(respond)
                }
            })
            $("#modal-detailmenu").modal("show")
        })
    })

</script>
@endpush