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
            <div class="col-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4>Detail Project</h4>
                        <table class="table table-sm table-compact table-bordered">
                            <tr>
                                <th class="my-0 py-1">Kegiatan</th>
                                <td class="my-0 py-2">{{ $absensi->nama }}</td>
                            </tr>
                            <tr>
                                <th class="my-0 py-1">Proyek</th>
                                <td class="my-0 py-2">{{ ($absensi->project_id == 0) ? 'Semua Proyek' : $absensi->project->nama }}</td>
                            </tr>
                            <tr>
                                <th class="my-0 py-1">Tanggal</th>
                                <td class="my-0 py-2">{{ $absensi->tgl }}</td>
                            </tr>
                            <tr>
                                <th class="my-0 py-1">Jam</th>
                                <td class="my-0 py-2">{{ $absensi->jam_masuk }} - {{ $absensi->jam_keluar }}</td>
                            </tr>
                            <tr>
                                <th class="my-0 py-1">Jml Peserta</th>
                                <td class="my-0 py-2">{{ $absensi_karyawan->count() + $belum_absen->count() }} Orang</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-9">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4>Daftar Karyawan</h4>
                        <table class="table text-center table-bordered" width="100%">
                            <tr>
                                <th>NO</th>
                                <th>NIK</th>
                                <th>NAMA</th>
                                {{-- <th>PROYEK</th> --}}
                                <th>KETERANGAN</th>
                                <th>TERLAMBAT</th>
                                <th>WAKTU PRESENSI</th>
                                <th>WAKTU KELUAR</th>
                                {{-- <th>KET</th> --}}
                            </tr>

                            <?php $no = 1 ?>
                            @if ($absensi_karyawan->count() > 0)
                                @foreach ($absensi_karyawan as $absen)
                                    @if ($absen->absen_masuk !== null || $absen->izinkan !== null)
                                        <?php $no = $loop->iteration ?>
                                        
                                        {{-- if $absen->karyawan != null background color of tr light red --}}
                                        <tr @if($absen->karyawan->deleted_at != null) style="background-color: #ffcccc" @endif>
                                            <td>{{ $no }}</td>
                                            <td>{{ $absen->karyawan->no_induk }}</td>
                                            <td>{{ $absen->karyawan->nama }}</td>
                                            {{-- <td>{{ $absen->karyawan->project->nama }}</td> --}}
                                            <td align="center">
                                                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 5px; max-width: 130px;">
                                                    @if($absen->telat == 1) 
                                                        <span class="badge badge-secondary">terlambat</span>
                                                    @elseif ($absen->absen_masuk !== null && $absen->absen_keluar !== null)
                                                        <span class="badge badge-primary">hadir</span>
                                                    @endif
                                                    
                                                    @if ( Str::substr($absen->absen_masuk, 11, 5) <= $absensi->jam_masuk && Str::substr($absen->absen_keluar, 11, 5) >= $absensi->jam_keluar)
                                                        <span class="badge badge-success">tepat waktu</span>
                                                    @endif

                                                    @if($absen->izinkan !== null && $absen->izinkan == 0)
                                                        <span class="badge badge-danger">tidak hadir</span>
                                                    @elseif($absen->izinkan !== null && $absen->izinkan == 1)
                                                        <span class="badge badge-info">izin</span>
                                                    @elseif($absen->absen_masuk == null && $absen->absen_keluar == null)
                                                        <span class="badge badge-danger">tidak hadir</span>
                                                    @elseif($absen->absen_masuk != null && $absen->absen_keluar == null)
                                                        <span class="badge badge-warning">belum absen keluar</span>
                                                    @endif
                                                    
                                                    @if($absen->absen_masuk != null && $absen->absen_keluar != null && Str::substr($absen->absen_keluar, 11, 8) < $absensi->jam_keluar)
                                                        <span class="badge badge-warning">keluar sebelum waktunya</span>
                                                    @endif

                                                    @if($absen->karyawan->deleted_at != null)
                                                        <span class="badge badge-danger">deleted</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <?php 
                                                    $masuk = Str::substr($absen->absen_masuk, 11, 5);
                                                    $jam_masuk = $absensi->jam_masuk;
                                                    
                                                    // carbon diff hour minute second
                                                    $telat = \Carbon\Carbon::parse($masuk)->diff($jam_masuk)->format('%I menit %S detik');
                                                ?>
                                                @if ($absen->telat == 1) <kbd class="bg-danger">{{ $telat }}</kbd> @endif
                                                @if ($absen->izinkan !== null && $absen->izinkan == 1) izin @endif
                                                @if ($absen->izinkan !== null && $absen->izinkan == 0) tidak hadir @endif
                                            </td>
                                            <td>{{ ($absen->absen_masuk != null) ? Str::substr($absen->absen_masuk, 11, 5) : ($absen->izinkan !== null && $absen->izinkan == 0 ? 'tidak hadir' : '-') }}</td>
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
                                    <tr @if($absen->karyawan->deleted_at != null) style="background-color: #ffcccc" @endif>
                                        <td>{{ $no }}</td>
                                        <td>{{ $absen->karyawan->no_induk }}</td>
                                        <td>{{ $absen->karyawan->nama }}</td>
                                        <td> 
                                            @if ($absen->karyawan->deleted_at != null)
                                                <span class="badge badge-danger">deleted</span>
                                            @else
                                                -
                                            @endif
                                        </td>
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