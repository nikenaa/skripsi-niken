@extends('template.main')
@section('content')
@include('template.nav.siswa')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Permohonan Izin</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/siswa/absensi') }}">Absensi</a></li>
                        <li class="breadcrumb-item active">Permohonan Izin</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class=" card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0 mb-3">Permohonan Izin {{ $absensi->nama }}</h4>
                        @if ($absensi_siswa->izinkan !== null)
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="th">KETERANGAN</th>
                                            <th class="th">FILE</th>
                                            <th class="th">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center">{{ $absensi_siswa->keterangan }}</td>
                                            <td align="center">
                                                <a href="{{ url('/siswa/suket/' . $absensi_siswa->suket) }}" class="btn btn-success">Unduh</a>
                                            </td>
                                            <td align="center">
                                                @if ($absensi_siswa->izinkan === 0)
                                                    <a href="javascript:void(0);" class="badge badge-warning">Pending</a>
                                                @else
                                                    <a href="javascript:void(0);" class="badge badge-success">Di izinkan</a>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ url('/siswa/absensi') }}" class="btn btn-danger">kembali</a>
                        @else
                            @if ($absensi_siswa->absen_masuk === null)
                                <div class="waktu">
                                    <form action="{{ url('/siswa/izin/' . $absensi->kode) }}" method="POST" class="form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Keterangan</label>
                                            <input type="text" name="keterangan" class="form-control" placeholder="eg: sakit demam" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Bukti</label><br>
                                            <input type="file" name="suket" required accept="image/*,.pdf,.doc,.docx">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Kirim Permohonan</button>
                                        <a href="{{ url('/siswa/absensi') }}" class="btn btn-danger">kembali</a>
                                    </form>
                                </div>
                            @else
                                <p>Anda tidak dapat mengirimkan permohonan izin dikarenakan Anda sudah melakukan Absensi</p>
                                <a href="{{ url('/siswa/absensi') }}" class="btn btn-danger">kembali</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class=" card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0 mb-3">Warning!</h4>
                        <p>Contoh Bukti<br>surat ketarangan sakit dari dokter berupa foto ataupun pdf</p>

                        <p>Diharuskan memasukan bukti dengan format gambar ataupun dokumen</p>
                        <span class="blockquote-footer"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>

<script>

    @if ($absensi_siswa->absen_masuk === null)
    var link = "{{ url('siswa/absensi') }}";
        var countDownDate=new Date("{{ $absensi->tgl }} {{ $absensi->jam_keluar }}").getTime(),x=setInterval(function(){var a=(new Date).getTime(),a=countDownDate-a;Math.floor(a/864e5),Math.floor(a%864e5/36e5),Math.floor(a%36e5/6e4),Math.floor(a%6e4/1e3);a<0&&(clearInterval(x),$(".waktu").html('<div class="alert alert-danger">Absensi telah berakhir, Anda tidak dapat mengirimkan permohonan izin</div><a href="'+ link +'" class="btn btn-danger">kembali</a>'))},500);
    @endif

</script>

{!! session('pesan') !!}
@endsection