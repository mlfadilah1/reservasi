<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard | Sundaa Coffee')</title>
    <link rel="shortcut icon" type="image/png" href="auth/images/logos/sundacoffee.png" />
    <link rel="stylesheet" href="auth/css/styles.min.css" />
    <link rel="stylesheet" href="auth/css/icons/tabler-icons/tabler-icons.css" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" href="fontawesome-free-6.4.2-web/css/all.css">
    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>

<body>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('admin.sidebar')
        <!-- Main wrapper -->
        <div class="body-wrapper">
            <!-- Header Start -->
            <header class="app-header">
                @include('admin.header')
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
            @include('admin.footer')
        </div>

    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}
    <script src="auth/libs/jquery/dist/jquery.min.js"></script>
    <script src="auth/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="auth/js/sidebarmenu.js"></script>
    <script src="auth/js/app.min.js"></script>
    <script src="auth/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="auth/libs/simplebar/dist/simplebar.js"></script>
    {{-- <script src="auth/js/dashboard.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <link rel="stylesheet" href="fontawesome-free-6.4.2-web/js/all.js">
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
    {{-- sweetalert --}}
    {{-- <script src="sweetalert2.min.js"></script> --}}
    <script>
        $(function() {
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: "Apakah anda yakin menghapus data ini?",
                    text: "Anda tidak akan dapat mengembalikan data ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Saya Yakin!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Hapus!",
                            text: "Data Telah Terhapus.",
                            icon: "success"
                        });
                    }
                });
            })
        })
    </script>
    @include('sweetalert::alert')
</body>

</html>
