<table class="table" id="table" class="display">
    <thead class="text-center">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Meja</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Harga (Pcs)</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
            $prevTanggal = '';
            $prevMeja = '';
        @endphp
        @if ($detail)
            @foreach ($detail as $data)
                <tr>
                    <td>{{ $no++ }}</td>
                    @if ($data->tanggal != $prevTanggal || $data->id_meja != $prevMeja)
                        <td rowspan="{{ $detail->where('tanggal', $data->tanggal)->where('id_meja', $data->id_meja)->count() }}" class="align-middle">{{ $data->tanggal }}</td>
                        <td rowspan="{{ $detail->where('tanggal', $data->tanggal)->where('id_meja', $data->id_meja)->count() }}" class="align-middle">{{ $data->id_meja }}</td>
                        @php
                            $prevTanggal = $data->tanggal;
                            $prevMeja = $data->id_meja;
                        @endphp
                    @else
                        {{-- Tanggal dan meja disimpan di sel pertama pada grup, tidak perlu lagi di baris lainnya --}}
                    @endif
                    <td>{{ $data->nama_menu }}</td>
                    <td class="text-center">{{ $data->jumlah }}</td>
                    <td class="text-center">{{ $data->harga }}</td>
                    <td class="text-center">{{ $data->harga }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>