@extends('template.main')
@section('content')
@include('template.nav.admin')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">
                        Absen Masuk {{ $absensi->nama }}
                        <br>
                        {{ ($absensi->project_id == 0) ? 'Semua Proyek' : $absensi->project->nama }}
                    </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Presensi</a></li>
                        <li class="breadcrumb-item active">{{ $absensi->nama }}</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center absen-container">
                <h1>SCAN HERE!</h1>
                <div class="mt-2">
                    <center>
                        <div class="alert alert-warning text-dark h6" id="countdown-masuk-wrapper">Absensi dimulai dalam : <span id="countdown-masuk">0 Hari 0 Jam 0 Menit 0 Detil</span></div>
                        <div id="qrEvent" style="display:none;"></div>
                    </center>
                </div>
                <a href="{{ url('/admin/cetakqr/' . $absensi->kode) }}" target="_blank" style="display:none;" class="btn btn-primary mt-2 mx-auto" id="export-qr">Export QR</a>
                <div class="alert alert-warning text-dark h6" id="countdown-keluar-wrapper" style="display:none;">Absensi Selesai dalam : <span id="countdown-keluar">0 Hari 0 Jam 0 Menit 0 Detil</span></div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-2">Sudah Presensi</h4>
                        <div class="friends-suggestions">
                            <div class="row" id="sudah-absen">
                                <button class="btn btn-primary btn-block" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-2">Belum Presensi</h4>
                        <div class="friends-suggestions">
                            <div class="row" id="belum-absen">
                                <button class="btn btn-primary btn-block" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->

<script>
    var masukDate = new Date("{{ $absensi->tgl }} {{ $absensi->jam_masuk }}").getTime();
    var keluarDate = new Date("{{ $absensi->tgl }} {{ $absensi->jam_keluar }}").getTime();

    // Fungsi untuk menampilkan hitungan mundur
    function showCountdown(targetDate, elementId, message) {
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = targetDate - now;

            var days    = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById(elementId).innerHTML = days + "H " + hours + "J " + minutes + "M " + seconds + "D ";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById(elementId).innerHTML = message;
            }
        }, 1000);
    }

    // Menampilkan hitungan mundur menuju jam masuk
    showCountdown(masukDate, "countdown-masuk", "Waktu absensi telah dimulai!");

    // Fungsi untuk memulai absensi
    function startAbsensi() {
        document.getElementById("countdown-masuk-wrapper").style.display = "none"; // Menyembunyikan hitungan mundur jam masuk
        document.getElementById("countdown-keluar-wrapper").style.display = "block"; // Menampilkan hitungan mundur jam keluar
        document.getElementById("qrEvent").style.display = "block";
        document.getElementById("export-qr").style.display = "block";

        new QRCode(document.getElementById("qrEvent"), "{{ $absensi->kode }}");

        setInterval(() => {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                type: "POST",
                data: {
                    content: "{{ $absensi->kode }}",
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ url('/admin/sudah_absen') }}",
                async: true,
                success: function(e) {
                    $("#sudah-absen").html(e)
                }
            })
        }, 3000);

        setInterval(() => {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                type: "POST",
                data: {
                    content: "{{ $absensi->kode }}",
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ url('/admin/belum_absen') }}",
                async: true,
                success: function(e) {
                    $("#belum-absen").html(e)
                }
            })
        }, 3000);
    }

    // Memeriksa setiap 1 detik apakah sudah waktunya jam masuk
    var checkMasukInterval = setInterval(function() {
        var now = new Date().getTime();

        if (now >= masukDate) {
            clearInterval(checkMasukInterval);
            document.getElementById("countdown-masuk").innerHTML = "Waktu absensi telah dimulai!";
            startAbsensi();
        }
    }, 1000);

    // Menampilkan hitungan mundur menuju jam keluar
    var countDownDate = keluarDate;
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;

        var days    = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("countdown-keluar").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

        if (distance < 0) {
            clearInterval(x);
            $(".absen-container").html('<div class="alert alert-success">Absen Telah Berakhir!</div>');
        }
    }, 1000);
</script>
{!! session('pesan') !!}

@endsection