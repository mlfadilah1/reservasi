<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dokumen</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

    <h1>Perbandingan User dan Item</h1>

    <section>
        <h2>Data Rating</h2>
        <table>
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Menu</th>
                    <th>Rating</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($userRating as $rating)
                    <tr>
                        <td>{{ $rating->user_name }}</td>
                        <td>{{ $rating->nama_menu }}</td>
                        <td>{{ number_format($rating->bintang, 1) }}</td>
                        <td>{{ $rating->kategori }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Tidak ada data rating.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <section>
        <h2>Rata-Rata Rating Pengguna</h2>
        <table>
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Rata-Rata Rating</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($averageUserRatings as $user => $avg)
                    <tr>
                        <td>{{ $user }}</td>
                        <td>{{ number_format($avg, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Tidak ada data rata-rata rating pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <section>
        <h2>Kemiripan Antar Pengguna</h2>
        @forelse ($userSimilaritiesByCategory as $category => $userSimilarities)
            <h3>Kategori: {{ $category }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Pasangan Pengguna</th>
                        <th>Kemiripan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($userSimilarities as $pair => $similarity)
                        <tr>
                            <td>{{ $pair }}</td>
                            <td>{{ number_format($similarity, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Tidak ada data kemiripan untuk kategori ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @empty
            <p>Tidak ada data kemiripan pengguna.</p>
        @endforelse
    </section>

    <section>
        <h2>Rekomendasi untuk Pengguna</h2>
        @forelse ($recommendationsByCategory as $category => $recommendations)
            <h3>Kategori: {{ $category }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recommendations as $item)
                        <tr>
                            <td>{{ $item }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td>Tidak ada rekomendasi untuk kategori ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @empty
            <p>Tidak ada data rekomendasi.</p>
        @endforelse
    </section>

    <section>
        <h2>Menu Paling Sering Dibeli per Kategori</h2>
        @forelse ($menuFrequencyByCategory as $category => $menuFrequency)
            <h3>Kategori: {{ $category }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Frekuensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menuFrequency as $menu => $frequency)
                        <tr>
                            <td>{{ $menu }}</td>
                            <td>{{ $frequency }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Tidak ada data frekuensi menu untuk kategori ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @empty
            <p>Tidak ada data frekuensi menu.</p>
        @endforelse
    </section>

    <section>
        <h2>Menu Paling Sering Dibeli oleh Pengguna Ini per Kategori</h2>
        @forelse ($userMenuFrequencyByCategory as $category => $userMenuFrequency)
            <h3>Kategori: {{ $category }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Frekuensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($userMenuFrequency as $menu => $frequency)
                        <tr>
                            <td>{{ $menu }}</td>
                            <td>{{ $frequency }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Tidak ada data frekuensi menu untuk pengguna ini di kategori ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @empty
            <p>Tidak ada data frekuensi menu untuk pengguna ini.</p>
        @endforelse
    </section>

</body>
</html>
