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
                    {{-- <a href="#reservasi" class="nav-item nav-link">Reservasi</a> --}}
                    <a href="#rating" class="nav-item nav-link">Rating</a>
                    <a href="#tentangkami" class="nav-item nav-link">Tentang Kami</a>
                </div>
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