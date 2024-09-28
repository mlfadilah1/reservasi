@extends('customer.app')

@section('content')
<section id="reservasi">
    <div class="container-fluid contact py-6 wow bounceInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-0">
                <div class="col-12">
                    <div class="text-center">
                        <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Pesanan
                            Menu</small>
                        <h1 class="display-5 mb-5">Pesanan Anda</h1>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr align="center">
                                <th>No</th>
                                <th>Meja</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Jumlah Tamu</th>
                                <th>Total Harga</th>
                                {{-- <th>Status</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @forelse ($reservasi as $data)
                            <tr align="center">
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->no_meja }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->tanggal }}</td>
                                <td>{{ $data->jumlah_tamu }}</td>
                                <td>Rp. {{ $data->total_harga }}</td>
                                {{-- <td>
                                    @if ($data->status == 'Menunggu Pembayaran')
                                    <span class="badge bg-warning text-dark">{{ $data->status }}</span>
                                    @elseif($data->status == 'Ditolak')
                                    <span class="badge bg-danger text-white">{{ $data->status }}</span>
                                    @else
                                    <span class="badge bg-success text-white">{{ $data->status }}</span>
                                    @endif
                                </td> --}}
                                <td>
                                    <button class="btn btn-secondary">
                                        <a class="dropdown-item edit" id="{{ $data->id_reservasi }}" href="#">Detail</a>
                                    </button> 
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak Ada Data Pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-detailpesanan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" >Detail Pesanan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="loaddetail">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Simpan</button>
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
                , url: `detailpesanan/${id}`
                , cache: false
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id: id
                }
                , success: function(respond) {
                    $("#loaddetail").html(respond)
                }
            })
            $("#modal-detailpesanan").modal("show")
        })
    })

</script>
@endpush
