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
                        Absen Keluar {{ $absensi->nama }}
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
            <div class="col-lg-8 offset-lg-2 text-center">
                <h1>SCAN HERE!</h1>
                <div class="mt-2">
                    <center>
                        <div id="waktu">
                            <div class="alert alert-danger"></div>
                        </div>
                        <div id="qrEvent" style="display: none;"></div>
                        <div id="sudah-selesai" style="display: none;" class="alert alert-info">Absensi telah selesai!</div>
                    </center>
                </div>
                <a href="{{ url('/admin/cetakqr/' . $absensi->kode) }}" target="_blank"
                    class="btn btn-primary mt-2 ml-auto cetak" style="display: none;">Export QR</a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-2">Sudah Presensi Keluar</h4>
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
                        <h4 class="mt-0 header-title mb-2">Belum Presensi Keluar</h4>
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
    new QRCode(document.getElementById("qrEvent"), "{{ $absensi->kode }}");

    function updatePresensiStatus() {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            type: "POST",
            data: {
                content: "{{ $absensi->kode }}",
                _token: "{{ csrf_token() }}"
            },
            url: "{{ url('/admin/sudah_absen_keluar') }}",
            async: true,
            success: function(e) {
                $("#sudah-absen").html(e)
            }
        });

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            type: "POST",
            data: {
                content: "{{ $absensi->kode }}",
                _token: "{{ csrf_token() }}"
            },
            url: "{{ url('/admin/belum_absen_keluar') }}",
            async: true,
            success: function(e) {
                $("#belum-absen").html(e)
            }
        });
    }

    setInterval(updatePresensiStatus, 3000);

    var waktuMasuk = new Date("{{ $absensi->tgl }} {{ $absensi->jam_masuk }}").getTime();
    var waktuKeluar = new Date("{{ $absensi->tgl }} {{ $absensi->jam_keluar }}").getTime();
    var waktuKeluarMin15 = waktuKeluar - 15 * 60 * 1000; // 15 minutes before jam_keluar
    var waktuKeluarPlus30 = waktuKeluar + 30 * 60 * 1000; // 30 minutes after jam_keluar

    setInterval(function() {
        var currentTime = new Date().getTime();

        if (currentTime >= waktuKeluarMin15 && currentTime <= waktuKeluarPlus30) {
            $("#qrEvent").css("display", "block");
            $("#waktu").css("display", "none");
            $("#waktu").children().text("");            // <- clear the text 
            $(".cetak").css("display", "inline-block");

            if (currentTime > waktuKeluarPlus30) {
                $("#qrEvent").css("display", "none");
                $("#waktu").css("display", "block");
                $("#waktu").children().text("Waktu Absen Keluar telah berakhir!"); // <- set the text
                $(".cetak").css("display", "none");
            }
        } else if (currentTime < waktuKeluarMin15) {
            $("#waktu").css("display", "block");
            $("#waktu").children().text("Belum saatnya Absen Keluar, atau belum saatnya presensi dimulai !"); // <- set the text
            $("#qrEvent").css("display", "none");
            $(".cetak").css("display", "none");
        } else {
            $("#qrEvent").css("display", "none");
            $("#waktu").css("display", "block");
            $("#waktu").children().text("Waktu Absen telah berakhir!"); // <- set the text
            $(".cetak").css("display", "none");
        }
    }, 500);
</script>
{!! session('pesan') !!}

@endsection
