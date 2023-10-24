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
                            {{ ($absensi->project_id === 0) ? 'Semua Project' : $absensi->project->nama }}
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
                            <div id="qrEvent"></div>
                        </center>
                    </div>
                    <a href="{{ url('/admin/cetakqr/' . $absensi->kode) }}" target="_blank" class="btn btn-primary mt-2 ml-auto">Export QR</a>
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
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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
        new QRCode(document.getElementById("qrEvent"),"{{ $absensi->kode }}"),setInterval(()=>{$.ajax({headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"},type:"POST",data:{content:"{{ $absensi->kode }}",_token:"{{ csrf_token() }}"},url:"{{ url('/admin/sudah_absen') }}",async:!0,success:function(e){$("#sudah-absen").html(e)}})},3e3),setInterval(()=>{$.ajax({headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"},type:"POST",data:{content:"{{ $absensi->kode }}",_token:"{{ csrf_token() }}"},url:"{{ url('/admin/belum_absen') }}",async:!0,success:function(e){$("#belum-absen").html(e)}})},3e3);var countDownDate=new Date("{{ $absensi->tgl }} {{ $absensi->jam_keluar }}").getTime(),x=setInterval(function(){var e=(new Date).getTime(),e=countDownDate-e;Math.floor(e/864e5),Math.floor(e%864e5/36e5),Math.floor(e%36e5/6e4),Math.floor(e%6e4/1e3);e<0&&(clearInterval(x),$(".absen-container").html('<div class="alert alert-success">Absen Telah Berakhir!</div>'))},500);
    </script>
    {!! session('pesan') !!}

@endsection