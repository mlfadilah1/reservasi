<!doctype html>
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

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Template Stylesheet -->
    <link href="index/css/style.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="auth/images/logos/sundacoffee.png" />
    {{-- toastr --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> --}}
</head>

<body>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        {{-- @include('customer.sidebar') --}}
        <!-- Main wrapper -->
        <div class="body-wrapper">
            <!-- Header Start -->
            <header class="app-header">
                @include('customer.navbar')
            </header>
            <!-- Header End -->
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    {{-- <div class="section-header">
                        <h1>Dashboard</h1>
                    </div> --}}

                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
            </div>
            @include('customer.footer')
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="index/lib/wow/wow.min.js"></script>
    <script src="index/lib/easing/easing.min.js"></script>
    <script src="index/lib/waypoints/waypoints.min.js"></script>
    <script src="index/lib/counterup/counterup.min.js"></script>
    <script src="index/lib/lightbox/js/lightbox.min.js"></script>
    <script src="index/lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Template Javascript -->
    <script src="index/js/main.js"></script>
    @include('sweetalert::alert')
    {{-- toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @stack('myscript')
</body>

</html>
