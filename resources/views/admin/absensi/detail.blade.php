@extends('template.main')
@section('content')
@include('template.nav.admin')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">
                        Detail Absensi
                    </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/data_absensi') }}">Absensi</a></li>
                        <li class="breadcrumb-item active">Detail Absensi</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4>Detail Project</h4>
                        <table class="table table-sm table-compact table-bordered">
                            <tr>
                                <th width="200px">Kegiatan</th>
                                <td>{{ $absensi->nama }}</td>
                            </tr>
                            <tr>
                                <th width="200px">Proyek</th>
                                <td>{{ ($absensi->project_id == 0) ? 'Semua Proyek' : $absensi->project->nama }}</td>
                            </tr>
                            <tr>
                                <th width="200px">Tanggal</th>
                                <td>{{ $absensi->tgl }}</td>
                            </tr>
                            <tr>
                                <th width="200px">Jam</th>
                                <td>{{ $absensi->jam_masuk }} - {{ $absensi->jam_keluar }}</td>
                            </tr>
                            <tr>
                                <th width="200px">Jumlah Peserta</th>
                                <td>{{ $absensi_karyawan->count() + $belum_absen->count() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4>Daftar Karyawan</h4>
                        <table class="table text-center table-bordered" width="100%">
                            <tr>
                                <th>NO</th>
                                <th>NIK</th>
                                <th>NAMA</th>
                                {{-- <th>PROYEK</th> --}}
                                <th>WAKTU PRESENSI</th>
                                <th>KETERANGAN</th>
                                <th>WAKTU KELUAR</th>
                                {{-- <th>KET</th> --}}
                            </tr>

                            <?php $no = 1 ?>
                            @if ($absensi_karyawan->count() > 0)
                                @foreach ($absensi_karyawan as $absen)
                                    @if ($absen->absen_masuk !== null || $absen->izinkan !== null)
                                        <?php $no = $loop->iteration ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $absen->karyawan->no_induk }}</td>
                                            <td>{{ $absen->karyawan->nama }}</td>
                                            {{-- <td>{{ $absen->karyawan->project->nama }}</td> --}}
                                            <td>{{ ($absen->absen_masuk != null) ? Str::substr($absen->absen_masuk, 11, 5) :
                                                ($absen->izinkan !== null && $absen->izinkan == 0 ? 'tidak hadir' : '-') }}</td>
                                            <td>
                                                <?php 
                                                    $masuk = Str::substr($absen->absen_masuk, 11, 5);
                                                    $jam_masuk = $absensi->jam_masuk;
                                                    
                                                    $telat = strtotime($masuk) - strtotime($jam_masuk);
                                                    $telat = $telat / 60;
                                                ?>
                                                @if ($absen->telat == 1) terlambat ( {{ $telat }} menit ) @endif
                                                @if ($absen->izinkan !== null && $absen->izinkan == 1) izin @endif
                                                @if ($absen->izinkan !== null && $absen->izinkan == 0) tidak hadir @endif
                                            </td>
                                            <td>
                                                @if ($absen->izinkan !== null && $absen->izinkan == 0)
                                                tidak hadir
                                                @elseif ($absen->izinkan !== null && $absen->izinkan == 1)
                                                -
                                                @else
                                                {{ ($absen->absen_keluar == null) ? 'belum absen' :
                                                Str::substr($absen->absen_keluar, 11, 5) }}
                                                @endif
                                            </td>
                                            {{-- <td>{{ ($absen->keterangan == null) ? '-' : $absen->keterangan }}</td> --}}
                                        </tr>
                                    @endif
                                @endforeach
                            @endif

                            @if ($belum_absen->count() > 0)
                                @foreach ($belum_absen as $absen)
                                    <?php $no = $no + 1 ?>
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $absen->karyawan->no_induk }}</td>
                                        <td>{{ $absen->karyawan->nama }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection