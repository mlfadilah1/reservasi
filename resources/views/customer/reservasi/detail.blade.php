<table class="table table-detail" id="table" class="display">
    <thead class="text-center bg-light">
        <tr>
            <th>Tanggal</th>
            <th>Meja</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Harga (Pcs)</th>
            <th class="text-right">Rating</th>
        </tr>
    </thead>
    <tbody>
        @php
            $lastMenu = null;
            $sortedData = $datareservasi->sortBy(function($data) {
                return is_null($data->bintang) ? 0 : 1;
            });
        @endphp
        @foreach ($sortedData as $data)
            @if ($data->nama_menu !== $lastMenu)
                @php $lastMenu = $data->nama_menu; @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</td>
                    <td class="text-center">{{ $data->id_meja }}</td>
                    <td>{{ $data->nama_menu }}</td>
                    <td class="text-center">{{ $data->jumlah }}</td>
                    <td class="text-right">{{ number_format($data->harga, 0, ',', '.') }}</td>
                    <td class="text-right">
                        @if ($data->bintang)
                            <div class="stars d-inline-block">
                                @for ($i = 5; $i >= 1; $i--)
                                    <span class="star {{ $i <= $data->bintang ? 'text-warning' : '' }}">&#9733;</span>
                                @endfor
                            </div>
                            <br/>
                            <small><strong>Ulasan:</strong> {{ $data->ulasan }}</small>
                        @else
                            @php $canRate = $data->status === 'Selesai'; @endphp
                            @if ($canRate)
                                <form action="{{ route('submitrating', ['id_menu' => $data->id_menu]) }}" method="POST" class="rating-form">
                                    @csrf
                                    <input type="hidden" name="id_menu" value="{{ $data->id_menu }}">
                                    <input type="hidden" name="id_reservasi" value="{{ $data->id_reservasi }}">
                                    <input type="hidden" name="id_user" value="{{ Auth::id() }}">
                                    <div class="stars d-inline-block mb-2">
                                        @for ($i = 5; $i >= 1; $i--) <!-- Urutan bintang dari kanan ke kiri -->
                                            <input type="radio" id="star{{ $i }}-{{ $data->id_menu }}" name="bintang" value="{{ $i }}" class="d-none">
                                            <label for="star{{ $i }}-{{ $data->id_menu }}" class="star">&#9733;</label>
                                        @endfor
                                    </div>
                                    <textarea name="ulasan" class="form-control mb-2" rows="2" placeholder="Tulis ulasan Anda"></textarea>
                                    <button type="submit" class="btn btn-sm btn-primary">Kirim Rating</button>
                                </form>
                            @else
                                <span class="text-muted">Belum Menyelesaikan Pesanan</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

<style>
    .stars {
        display: inline-block;
        direction: rtl; /* Membuat rating dari kanan ke kiri */
    }

    .stars label {
        font-size: 1.5em;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }

    /* Bintang yang di-hover atau dipilih */
    .stars input:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label {
        color: gold;
    }

    /* Tampilan rating yang sudah diberikan */
    .star.text-warning {
        color: gold;
    }

    .rating-form {
        display: inline-block;
        width: 100%;
        max-width: 250px;
    }

    textarea.form-control {
        resize: vertical;
        padding: 5px;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button.btn-primary {
        background-color: #b29F91;
        color: white;
        border: none;
        padding: 8px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9em;
        transition: background-color 0.3s;
    }

    button.btn-primary:hover {
        background-color: #BA7e76;
    }

    .text-muted {
        display: inline-block;
        margin-top: 5px;
    }
</style>

<script>
    document.querySelectorAll('.rating-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            const submitButton = this.querySelector('button');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Mengirim...';
        });
    });
</script>
