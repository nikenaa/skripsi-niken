<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ $judul }}</title>
    <meta content="Aplikasi Presensi Berbasis Website" name="description" />
    <meta content="" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/rb.png') }}">


    <link href="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/css/style.css" rel="stylesheet" type="text/css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <script src="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/js/jquery.min.js"></script>

    <!-- SWAL -->
    <script src="{{ asset('assets/template/presensi-abdul') }}/plugins/swal/sweetalert2.all.js"></script>

    <!-- QRCODE -->
    {{-- <script src="{{ asset('assets/template/presensi-abdul') }}plugins/qrcode/qrcode.js"></script> --}}

    <!-- Responsive datatable examples -->
    {{-- <link href="{{ asset('assets/template/presensi-abdul') }}/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> --}}

    <!-- Select 2 -->
    {{-- <link href="{{ asset('assets/template/presensi-abdul') }}/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" /> --}}

    {{-- <script src="{{ asset('assets') }}/qr/instascan.min.js"></script> --}}
    {!! $plugin_css !!}
    {!! $plugin_js !!}
</head>

<body>


    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        © 2022 E-Presensi QR Laravel 8 <span class="d-none d-sm-inline-block"> - built with <i class="mdi mdi-laravel text-danger" style="font-size: 18px"></i> by <a href="https://www.youtube.com/channel/UCvteoPo7Th3Q2Mdi9c8CT1w" target="_blank">Abdul Malela</a></span>
    </footer>

    <!-- End Footer -->

    <!-- jQuery  -->
    <script src="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/js/jquery.slimscroll.js"></script>
    <script src="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/js/waves.min.js"></script>

    <!-- App js -->
    <script src="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/js/app.js"></script>

    <!-- Select2 -->
    {{-- <script src="{{ asset('assets/template/presensi-abdul') }}/plugins/select2/select2.min.js"></script> --}}
    <script>
        $('.btn-logout').click(function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "anda harus login ulang untuk masuk ke aplikasi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        });
    </script>
</body>

</html>