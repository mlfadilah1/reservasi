<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sunda Coffee</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playball&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="index/lib/animate/animate.min.css" rel="stylesheet">
    <link href="index/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="index/lib/owlcarousel/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="index/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="index/css/style.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="auth/images/logos/sundacoffee.png" />
    {{-- toastr --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid nav-bar">
        <div class="container">
            <nav class="navbar navbar-light navbar-expand-lg py-4">
                <a href="index.html" class="navbar-brand">
                    <h3 class="text-primary fw-bold mb-0">Sunda<span class="text-dark">Coffee</span> </h3>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="/dashboard" class="nav-item nav-link active">Beranda</a>
                        {{-- <a href="#pesanan" class="nav-item nav-link">Pesanan</a> --}}
                        {{-- <a href="event.html" class="nav-item nav-link">Events</a> --}}
                        <a href="#menu" class="nav-item nav-link">Menu</a>
                        {{-- <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu bg-light">
                                <a href="book.html" class="dropdown-item">Booking</a>
                                <a href="blog.html" class="dropdown-item">Our Blog</a>
                                <a href="team.html" class="dropdown-item">Our Team</a>
                                <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                <a href="404.html" class="dropdown-item">404 Page</a>
                            </div>
                        </div> --}}
                        {{-- <a href="reservasi" class="nav-item nav-link">Reservasi</a> --}}
                        <a href="#rating" class="nav-item nav-link">Rating</a>
                        <a href="#tentangkami" class="nav-item nav-link">Tentang Kami</a>
                    </div>
                    {{-- <a href="pesanan" class="nav-item nav-link">
                        <i class="fas fa-shopping-cart"></i> Reservasi
                    </a> --}}
                    <!-- Dropdown Menu -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="reservasi">Keranjang</a></li>
                            <li><a class="dropdown-item" href="pesanan">Pesanan</a></li>
                        </ul>
                    </div>

                    {{-- <button class="btn-search btn btn-primary btn-md-square me-4 rounded-circle d-none d-lg-inline-flex"
                        data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search"></i></button>
                    <a href="{{ route('login') }}"
                        class="btn btn-primary py-2 px-4 d-none d-xl-inline-block rounded-pill">Login/Register</a> --}}
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            {{-- <img alt="image" src="{{ url('storage/users/' . Auth::user()->foto) }}"
                                class="img-fluid"> --}}
                            <div class="d-sm-none d-lg-inline-block"></div>{{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu bg-light">
                            {{-- <a href="profile" class="dropdown-item has-icon">
                                <i class="far fa-user"></i><span>Profile</span>
                            </a> --}}
                            <a href="{{ url('logout', []) }}" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Navbar End -->


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control bg-transparent p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->

    <!-- Hero Start -->
    <div class="container-fluid bg-light py-6 my-6 mt-0">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7 col-md-12">
                    <small
                        class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-4 animated bounceInDown">Sunda
                        Coffee</small>
                    <h1 class="display-1 mb-4 animated bounceInDown">Selamat Datang Di<span
                            class="text-primary">Sunda</span>Coffee
                        <spanclass="text-primary"></spanclass=>Silahkan Di Pesan
                    </h1>
                    {{-- <a href=""
                        class="btn btn-primary border-0 rounded-pill py-3 px-4 px-md-5 me-4 animated bounceInLeft">Book
                        Now</a> --}}
                    {{-- <a href=""
                        class="btn btn-primary border-0 rounded-pill py-3 px-4 px-md-5 animated bounceInLeft">Know
                        More</a> --}}
                </div>
                <div class="col-lg-5 col-md-12">
                    <img src="auth/images/logos/sundacoffee.png" class="img-fluid rounded animated zoomIn"
                        alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Menu Start -->
    <section id="menu">
        <div class="container-fluid menu bg-light py-6 my-6">
            <div class="container">
                <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                    <small class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">
                        Daftar Menu
                    </small>
                    <h1 class="display-5 mb-5">Menu Yang Tersedia Di Sunda Coffee</h1>
                </div>
    
                <div class="tab-class text-center">
                    <ul class="nav nav-pills d-inline-flex justify-content-center mb-5 wow bounceInUp" data-wow-delay="0.1s">
                        <li class="nav-item p-2">
                            <a class="d-flex py-2 mx-2 border border-primary bg-white rounded-pill active" data-bs-toggle="pill" href="#tab-all-recommendations">
                                <span class="text-dark" style="width: 150px;">Rekomendasi</span>
                            </a>
                        </li>
                        @foreach ($menuCategories as $category => $menus)
                            <li class="nav-item p-2">
                                <a class="d-flex py-2 mx-2 border border-primary bg-white rounded-pill" data-bs-toggle="pill" href="#tab-{{ $loop->index }}">
                                    <span class="text-dark" style="width: 150px;">{{ $category }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
    
                    <div class="tab-content">
                        <!-- Konten untuk Rekomendasi Gabungan -->
                        <div id="tab-all-recommendations" class="tab-pane fade show active p-0">
                            @php
                                $allRecommendations = [];
                                // Menggabungkan rekomendasi dari berbagai sumber
                                foreach ($menuCategories as $category => $menus) {
                                    if (!empty($recommendationsByCategory[$category])) {
                                        foreach ($recommendationsByCategory[$category] as $item) {
                                            $menu = $menus->firstWhere('nama_menu', $item);
                                            if ($menu) {
                                                $menu->rekomendasi_tipe = 'kemiripan';
                                                $allRecommendations[$menu->id_menu] = $menu;
                                            }
                                        }
                                    }
                                    // Rekomendasi berdasarkan frekuensi
                                    if (Auth::check() && !empty($userMenuFrequencyByCategory[$category])) {
                                        foreach ($userMenuFrequencyByCategory[$category] as $item => $count) {
                                            $menu = $menus->firstWhere('nama_menu', $item);
                                            if ($menu) {
                                                $menu->rekomendasi_tipe = 'frekuensi';
                                                $allRecommendations[$menu->id_menu] = $menu;
                                            }
                                        }
                                    }
                                }
                                // Menambahkan menu terlaris
                                foreach ($popularMenus as $popularMenu) {
                                    if (!isset($allRecommendations[$popularMenu->id_menu])) {
                                        $popularMenu->rekomendasi_tipe = 'terlaris';
                                        $allRecommendations[$popularMenu->id_menu] = $popularMenu;
                                    }
                                }
                                // Batasi rekomendasi menjadi 5
                                $allRecommendations = array_slice($allRecommendations, 0, 5);
                            @endphp
    
                            @if (empty($allRecommendations))
                                <p class="text-center">Belum ada rekomendasi untuk semua kategori.</p>
                            @else
                                <div class="row g-4">
                                    @foreach ($allRecommendations as $menu)
                                        <div class="col-lg-6 col-md-12 wow bounceInUp" data-wow-delay="0.1s">
                                            <div class="menu-item d-flex align-items-center">
                                                <img class="img-fluid rounded-circle menu-img" src="{{ url('../storage/menu/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}">
                                                <div class="w-100 d-flex flex-column text-start ps-4 details">
                                                    <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                                        <h4>{{ $menu->nama_menu }}</h4>
                                                        <h4 class="text-primary">Rp. {{ number_format($menu->harga, 0, ',', '.') }}</h4>
                                                    </div>
                                                    <p class="mb-0">{{ $menu->deskripsi }}</p>
                                                    <p class="mb-1">
                                                        @if ($menu->stok > 0)
                                                            <span class="badge bg-info text-dark">Tersedia</span>
                                                        @else
                                                            <span class="badge bg-danger text-white">Habis</span>
                                                        @endif
                                                    </p>                                                    
                                                    @if (isset($menu->rekomendasi_tipe))
                                                        <span class="badge {{ $menu->rekomendasi_tipe === 'kemiripan' ? 'bg-warning' : ($menu->rekomendasi_tipe === 'frekuensi' ? 'bg-success' : 'bg-danger') }}">
                                                            {{ $menu->rekomendasi_tipe === 'kemiripan' ? 'Menu yang Direkomendasikan' : ($menu->rekomendasi_tipe === 'frekuensi' ? 'Menu yang Sering Anda Pesan' : 'Menu Terlaris') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <form action="{{ route('tambah') }}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{ $menu->id_menu }}" name="id_menu">
                                                <input type="hidden" value="1" name="jumlah">
                                                <input type="hidden" value="{{ $menu->harga }}" name="total_harga">
                                                <button class="btn btn-primary" type="submit" {{ $menu->stok == 0 ? 'disabled' : '' }}>Tambah Keranjang</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
    
                        <!-- Konten untuk tiap kategori -->
                        @foreach ($menuCategories as $category => $menus)
                            <div id="tab-{{ $loop->index }}" class="tab-pane fade p-0">
                                @if ($menus->isEmpty())
                                    <p class="text-center">Belum ada menu tersedia di kategori ini.</p>
                                @else
                                    <div class="row g-4">
                                        @foreach ($menus as $menu)
                                            <div class="col-lg-6 col-md-12 wow bounceInUp" data-wow-delay="0.1s">
                                                <div class="menu-item d-flex align-items-center">
                                                    <img class="img-fluid rounded-circle menu-img" src="{{ url('../storage/menu/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}">
                                                    <div class="w-100 d-flex flex-column text-start ps-4 details">
                                                        <div class="d-flex justify-content-between border-bottom border-primary pb-2 mb-2">
                                                            <h4>{{ $menu->nama_menu }}</h4>
                                                            <h4 class="text-primary">Rp. {{ number_format($menu->harga, 0, ',', '.') }}</h4>
                                                        </div>
                                                        <p class="mb-0">{{ $menu->deskripsi }}</p>
                                                        <p class="mb-1">
                                                            <span class="badge bg-info text-dark">Stok: {{ $menu->stok > 0 ? $menu->stok : 'Habis' }}</span>
                                                        </p>
                                                        @if (isset($menu->rekomendasi_tipe))
                                                            <span class="badge {{ $menu->rekomendasi_tipe === 'kemiripan' ? 'bg-warning' : 'bg-success' }}">
                                                                {{ $menu->rekomendasi_tipe === 'kemiripan' ? 'Menu yang Direkomendasikan' : 'Menu yang Sering Anda Pesan' }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <form action="{{ route('tambah') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $menu->id_menu }}" name="id_menu">
                                                    <input type="hidden" value="1" name="jumlah">
                                                    <input type="hidden" value="{{ $menu->harga }}" name="total_harga">
                                                    <button class="btn btn-primary" type="submit" {{ $menu->stok == 0 ? 'disabled' : '' }}>Tambah Keranjang</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    
    
        
    

    

    <style>
        .badge {
            font-size: 0.875em;
            padding: 0.4em 0.8em;
            border-radius: 0.375rem;
            color: #fff;
            display: inline-block;
        }

        .bg-warning {
            background-color: #ffc107;
        }

        .bg-success {
            background-color: #28a745;
        }

        .menu-img {
            width: 150px;
            /* Atur ukuran gambar sesuai kebutuhan */
            height: 150px;
            /* Pastikan tinggi dan lebar sama agar gambar tetap berbentuk bulat */
            object-fit: cover;
            /* Menjaga proporsi gambar */
        }

        .menu-item {
            border: 1px solid #ddd;
            /* Gaya border untuk item menu */
            border-radius: 0.5rem;
            /* Penyesuaian border-radius */
            padding: 1rem;
            /* Spasi internal item menu */
            background-color: #fff;
            /* Warna latar belakang */
        }
    </style>

    <!-- Rekomendasi Menu -->
    {{-- <section id="recommendations">
        <div class="container-fluid bg-light py-6 my-6">
            <div class="container">
                <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                    <small
                        class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">
                        Rekomendasi Menu
                    </small>
                    <h1 class="display-5 mb-5">Rekomendasi Menu Berdasarkan Kategori</h1>
                </div>
                @foreach ($menuCategories as $category => $menus)
                    @if (isset($recommendationsByCategory[$category]) || (Auth::check() && !empty($userMenuFrequencyByCategory[$category])))
                        <div class="mb-5">
                            <h4>Kategori: {{ $category }}</h4>
                            <ul>
                                Menampilkan rekomendasi berdasarkan kemiripan antar pengguna
                                @if (!empty($recommendationsByCategory[$category]))
                                    <li>
                                        <strong>Rekomendasi Berdasarkan Kemiripan:</strong>
                                        <ul>
                                            @foreach ($recommendationsByCategory[$category] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif

                                Menampilkan rekomendasi berdasarkan menu yang sering dibeli oleh pengguna yang sedang login
                                @if (Auth::check() && !empty($userMenuFrequencyByCategory[$category]))
                                    <li>
                                        <strong>Menu Terbanyak Dipesan oleh Anda:</strong>
                                        <ul>
                                            @foreach ($userMenuFrequencyByCategory[$category] as $item => $count)
                                                <li>{{ $item }} ({{ $count }} kali)</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section> --}}
    <!-- JavaScript untuk mengatur tampilan rekomendasi berdasarkan tab -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.nav-link');
            const recommendationTabs = document.querySelectorAll('.recommendation-tab');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const categoryIndex = this.getAttribute('data-category');

                    recommendationTabs.forEach((recTab, index) => {
                        if (index == categoryIndex) {
                            recTab.style.display = 'block';
                        } else {
                            recTab.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    <!-- Menu End -->

    <!-- Testimonial Start -->
    <section id="rating">
        <div class="container-fluid py-6">
            <div class="container">
                <div class="text-center wow bounceInUp" data-wow-delay="0.1s">
                    <small
                        class="d-inline-block fw-bold text-dark text-uppercase bg-light border border-primary rounded-pill px-4 py-1 mb-3">Testimonial</small>
                    <h1 class="display-5 mb-5">"Lihat Apa Kata Pelanggan Kami tentang Menu Kami!"</h1>
                </div>
                <div class="owl-carousel owl-theme testimonial-carousel testimonial-carousel-1 mb-4 wow bounceInUp"
                    data-wow-delay="0.1s">
                    @if ($userRatings->isNotEmpty())
                        @foreach ($userRatings as $data)
                            <div class="testimonial-item rounded bg-light">
                                <div class="d-flex mb-3">
                                    <div class="position-absolute" style="top: 15px; right: 20px;">
                                        <i class="fa fa-quote-right fa-2x"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <h4 class="mb-0">{{ $data->user_name }}</h4>
                                        <p class="m-0">{{ $data->kategori }}</p>
                                    </div>
                                </div>
                                <div class="testimonial-content">
                                    <div class="d-flex">
                                        @for ($i = 0; $i < $data->bintang; $i++)
                                            <i class="fas fa-star text-primary"></i>
                                        @endfor
                                    </div>
                                    <!-- Menampilkan foto menu -->
                                    @if ($data->foto)
                                        <div class="menu-image mt-3">
                                            <img src="{{ asset('storage/menu/' . $data->foto) }}"
                                                alt="{{ $data->nama_menu }}" class="img-fluid rounded">
                                        </div>
                                    @endif
                                    <p>
                                    <h6>{{ $data->nama_menu }}</h6>
                                    </p>
                                    <p class="fs-5 m-0 pt-3">{{ $data->ulasan ?? 'Tidak ada ulasan.' }}</p>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <p class="text-center">Belum ada ulasan dari pelanggan.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial End -->

    <!-- Footer Start -->
    <section id="tentangkami">
        <div class="container-fluid footer py-6 my-6 mb-0 bg-light wow bounceInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-item">
                            <h1 class="text-primary">Sunda<span class="text-dark">Coffee</span></h1>
                            <p class="lh-lg mb-4">
                                Sunda Coffee, didirikan pada 2016 di Gunung Sunda, Sukabumi, memperkenalkan kopi lokal
                                dengan metode seduh manual.
                                Dikenal karena konsep outdoor, kedai ini resmi beroperasi pada 12 November 2016. Pada 28
                                Desember 2018, mereka membuka cabang baru, Sunda Coffee and Space, di Jl. Cikole Dalam,
                                Kota Sukabumi.
                            </p>
                            <div class="footer-icon d-flex">
                                {{-- <a class="btn btn-primary btn-sm-square me-2 rounded-circle" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-primary btn-sm-square me-2 rounded-circle" href="#"><i class="fab fa-twitter"></i></a> --}}
                                <a class="btn btn-primary btn-sm-square me-2 rounded-circle"
                                    href="https://www.instagram.com/sundacoffee/"><i class="fab fa-instagram"></i></a>
                                {{-- <a class="btn btn-primary btn-sm-square rounded-circle" href="#"><i class="fab fa-linkedin-in"></i></a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="footer-item">
                            <h4 class="mb-4">Special Facilities</h4>
                            <div class="d-flex flex-column align-items-start">
                                <a class="text-body mb-3" href="#"><i
                                        class="fa fa-check text-primary me-2"></i>Memiliki bar - Wi-Fi</a>
                                <a class="text-body mb-3" href="#"><i
                                        class="fa fa-check text-primary me-2"></i>Tempat duduk di area terbuka</a>
                                <a class="text-body mb-3" href="#"><i
                                        class="fa fa-check text-primary me-2"></i>Musik live</a>
                                <a class="text-body mb-3" href="#"><i
                                        class="fa fa-check text-primary me-2"></i>Kursi khusus pengguna kursi roda</a>
                                <a class="text-body mb-3" href="#"><i
                                        class="fa fa-check text-primary me-2"></i>Pintu masuk khusus pengguna kursi
                                    roda</a>
                                <a class="text-body mb-3" href="#"><i
                                        class="fa fa-check text-primary me-2"></i>Toilet khusus pengguna kursi roda</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="footer-item">
                            <h4 class="mb-4">Contact Us</h4>
                            <div class="d-flex flex-column align-items-start">
                                <p><i class="fa fa-map-marker-alt text-primary me-2"></i>Jl. Cikole Dalam No.38,
                                    Cikole, Kec. Cikole, Kota Sukabumi, Jawa Barat 43113</p>
                                <p><i class="fa fa-phone-alt text-primary me-2"></i>085794392725</p>
                                <p><i class="fa fa-clock text-primary me-2"></i>Senin - Jum'at: 07.30 AM - 10.00 PM</p>
                                <p><i class="fa fa-clock text-primary me-2"></i>Sabtu - Minggu: 07.30 AM - 11.00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Sunda
                            Coffee{{ date('Y') }}</a>, All right reserved.</span>
                </div>
                {{-- <div class="col-md-6 my-auto text-center text-md-end text-white">
                <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By
                <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
            </div> --}}
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-md-square btn-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="index/lib/wow/wow.min.js"></script>
    <script src="index/lib/easing/easing.min.js"></script>
    <script src="index/lib/waypoints/waypoints.min.js"></script>
    <script src="index/lib/counterup/counterup.min.js"></script>
    <script src="index/lib/lightbox/js/lightbox.min.js"></script>
    <script src="index/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="index/js/main.js"></script>

    {{-- toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @include('sweetalert::alert')
</body>

</html>
