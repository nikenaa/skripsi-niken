@extends('template.main')
@section('content')
@include('template.nav.siswa')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Riwayat Presensi</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item active">Riwayat Presensi</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0">Data Riwayat Presensi</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap" style="width: 100%">
                                <thead>
                                    <tr align="center">
                                        <th class="th">NAMA</th>
                                        <th class="th">TANGGAL</th>
                                        <th class="th">JAM</th>
                                        <th class="th">PROYEK</th>

                                        <th class="th bg-secondary text-white" style="width: 100px">KETERANGAN</th>
                                        <th class="th bg-secondary text-white">MASUK</th>
                                        <th class="th bg-secondary text-white">KELUAR</th>
                                        <th class="th bg-secondary text-white">TERLAMBAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($presensi_list->sortBy('id') as $presensi)
                                        @if ($presensi->project_id == $karyawan->project_id)
                                        <tr>
                                            <td align="center">{{ $presensi->nama }}</td>
                                            <td align="center">{{ \Carbon\Carbon::parse($presensi->tgl)->formatLocalized('%A, %d %B %Y') }}</td>
                                            <td align="center">{{ $presensi->jam_masuk }} - {{ $presensi->jam_keluar }}</td>
                                            <td align="center">{{ ($presensi->project_id == 0) ? 'Semua Proyek' : $presensi->project->nama }}</td>
                                            <td align="center" style="background-color: #f9f9f9;">
                                                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 5px;">
                                                    <?php $abs = $presensi->absensidetail_byid ?>
                                                    @if($abs && $abs->telat == 1) 
                                                        <span class="badge badge-secondary">terlambat</span>
                                                    @elseif ($abs && $abs->absen_masuk !== null && $abs->absen_keluar !== null)
                                                        <span class="badge badge-primary">hadir</span>
                                                    @endif
                                                    
                                                    @if ($abs && Str::substr($abs->absen_masuk, 11, 5) <= $presensi->jam_masuk && Str::substr($abs->absen_keluar, 11, 5) >= $presensi->jam_keluar)
                                                        <span class="badge badge-success">tepat waktu</span>
                                                    @endif

                                                    @if($abs && $abs->izinkan !== null && $abs->izinkan == 0)
                                                        <span class="badge badge-danger">tidak hadir</span>
                                                    @elseif($abs && $abs->izinkan !== null && $abs->izinkan == 1)
                                                        <span class="badge badge-info">izin</span>
                                                    @elseif($abs && $abs->absen_masuk == null && $abs->absen_keluar == null)
                                                        <span class="badge badge-danger">tidak hadir</span>
                                                    @elseif($abs && $abs->absen_masuk != null && $abs->absen_keluar == null)
                                                        <span class="badge badge-warning">belum absen keluar</span>
                                                    @endif
                                                    
                                                    @if($abs && $abs->absen_masuk != null && $abs->absen_keluar != null && Str::substr($abs->absen_keluar, 11, 8) < $presensi->jam_keluar)
                                                        <span class="badge badge-warning">keluar sebelum waktunya</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td align="center" style="background-color: #f9f9f9;">
                                                <?php $abs = $presensi->absensidetail_byid ?>
                                                @if($abs && $abs->absen_masuk !== null)
                                                    {{ Str::substr($abs->absen_masuk, 11, 8) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td align="center" style="background-color: #f9f9f9;">
                                                <?php $abs = $presensi->absensidetail_byid ?>
                                                @if($abs && $abs->absen_keluar !== null)
                                                    {{ Str::substr($abs->absen_keluar, 11, 8) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td align="center" style="background-color: #f9f9f9;">
                                                <?php $abs = $presensi->absensidetail_byid ?>
                                                @if($abs && $abs->telat == 1)
                                                    <?php 
                                                        $masuk = Str::substr($abs->absen_masuk, 11, 8);
                                                        $jam_masuk = $presensi->jam_masuk;
                                                        
                                                        $telat = strtotime($masuk) - strtotime($jam_masuk);
                                                        $menit = $telat / 60;
                                                        $detik = $telat % 60;
                                                    ?>
                                                    {{ floor($menit) }} menit {{ $detik }} detik
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        @else
                                            @if ($presensi->project_id == 0)
                                            <tr>
                                                <td align="center">{{ $presensi->nama }}</td>
                                                <td align="center">{{ \Carbon\Carbon::parse($presensi->tgl)->formatLocalized('%A, %d %B %Y') }}</td>
                                                <td align="center">{{ $presensi->jam_masuk }} - {{ $presensi->jam_keluar }}</td>
                                                <td align="center">{{ ($presensi->project_id == 0) ? 'Semua Proyek' : $presensi->project->nama }}</td>
                                            </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>

{!! session('pesan') !!}
@endsection