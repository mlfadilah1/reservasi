<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Nama Menu</th>
                        <th>Jumlah Pesanan</th>
                        <th>Pemesan</th>
                        <th>Tanggal Pesanan</th>
                        <th>Total Dipesan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mostPopularMenus as $menu)
                        <tr>
                            <td>{{ $menu->kategori }}</td>
                            <td>{{ $menu->nama_menu }}</td>
                            <td>{{ $menu->jumlah }} kali dipesan</td> <!-- Jumlah pesanan per menu -->
                            <td>{{ $menu->pemesan }}</td> <!-- Nama pemesan -->
                            <td>{{ \Carbon\Carbon::parse($menu->tanggal_pesanan)->format('d-m-Y') }}</td> <!-- Tanggal pesanan -->
                            <td>{{ $menu->jumlah_dipesan }}</td> <!-- Jumlah total dipesan -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
