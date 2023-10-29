@extends('template.main')
@section('content')
@include('template.nav.siswa')
<style>
    @media (min-width: 768px) { 
        #qr-reader{
            width: 500px;
            align-items: center;
        }
     }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Absen Keluar <br> {{ $absensi->nama }}</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Absen Keluar</a></li>
                        <li class="breadcrumb-item active">{{ $absensi->nama }}</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div id="result"></div>
                    @if ($absensi_karyawan->izinkan === null)

                        @if ($absensi_karyawan->absen_keluar == null)
                        
                            <div class="card-body card-body-scan">
                                <h4 class="card-title font-16 mt-0">Scan Here!</h4>
                                <div class="alert alert-danger waktu" style="position: relative; z-index: 9999;">Belum Saatnya Absen Keluar</div>
                                <div id="qr-reader" style="width: 100%;"></div>
                            </div>

                        @else
                            <div class="card-body">
                                <h4 class="card-title font-16 mt-0">Detail</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Waktu Absen</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>jam {{ Str::substr($absensi_karyawan->absen_masuk, 11, 5) }}</td>
                                                <td>
                                                    {!! ($absensi_karyawan->telat == 1) ? '<span class="badge badge-danger">Terlambat</span>' : '<span class="badge badge-primary">Sukses</span>' !!}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{ url('/siswa/absensi') }}" class="btn btn-danger">kembali</a>
                            </div>
                        @endif
                    
                    @else
                       <div class="card-body">
                            <h4 class="card-title font-16 mt-0">Detail</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Waktu Absen</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($absensi_karyawan->izinkan === 0)
                                            <tr align="center">
                                                <td>izin</td>
                                                <td>
                                                    <span class="badge badge-warning">PENDING</span>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($absensi_karyawan->izinkan === 1)
                                            <tr align="center">
                                                <td>izin</td>
                                                <td>
                                                    <span class="badge badge-warning">Di izinkan</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ url('/siswa/absensi') }}" class="btn btn-danger">kembali</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->


<script>
    @if ($absensi_karyawan->izinkan === null)
        @if ($absensi_karyawan->absen_keluar === null)
            var lastResult,countDownDate=new Date("{{ $absensi->tgl }} {{ $absensi->jam_keluar }}").getTime(),x=setInterval(function(){var e=(new Date).getTime(),e=countDownDate-e;Math.floor(e/864e5),Math.floor(e%864e5/36e5),Math.floor(e%36e5/6e4),Math.floor(e%6e4/1e3);e<0&&(clearInterval(x),$("#qr-reader").css("display","block"),$(".waktu").css("display","none"),new Html5QrcodeScanner("qr-reader",{fps:10,qrbox:250}).render(onScanSuccess))},500),countResults=0;function onScanSuccess(e,t){e!==lastResult&&(++countResults,lastResult=e,$.ajax({headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"},type:"POST",data:{content:e,_token:"{{ csrf_token() }}"},url:"{{ url('/siswa/absen_keluar') }}",async:!0,success:function(e){"error"==e&&Swal.fire({title:"Error",text:"Qr Code Tidak Terdeteksi",icon:"error",showCancelButton:!1,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"OK"}),"success"==e&&(Swal.fire({title:"Berhasil",text:"Anda sudah mengisi presensi",icon:"success",showCancelButton:!1,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"OK"}).then(e=>{e.isConfirmed&&location.reload()}),scanner.stop())}}))}
        @endif
    @endif
</script>


{!! session('pesan') !!}
@endsection
