@extends('template.main')
@section('content')
@include('template.nav.siswa')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Presensi</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item active">Presensi List</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-lg-10">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0">Presensi List</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap" style="width: 100%">
                                <thead>
                                    <tr align="center">
                                        <th class="th">NAMA</th>
                                        <th class="th">TANGGAL</th>
                                        <th class="th">JAM</th>
                                        <th class="th">PROJECT</th>
                                        <th class="th">ABSEN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($presensi_list->sortBy('id') as $presensi)
                                        @if ($presensi->project_id == $karyawan->project_id)
                                        <tr>
                                            <td align="center">{{ $presensi->nama }}</td>
                                            <td align="center">{{ $presensi->tgl }}</td>
                                            <td align="center">{{ $presensi->jam_masuk }} - {{ $presensi->jam_keluar }}</td>
                                            <td align="center">{{ ($presensi->project_id == 0) ? 'Semua Project' :
                                                $presensi->project->nama }}</td>
                                            <td align="center">
                                                <div class="btn-group">
                                                    <a href="{{ url('siswa/absensi/' . $presensi->kode) }}" class="btn btn-primary">Masuk</a>
                                                    <a href="{{ url('siswa/absensi_keluar/' . $presensi->kode) }}" class="btn btn-success">Keluar</a>
                                                    <a href="{{ url('siswa/izin/' . $presensi->kode) }}" class="btn btn-warning">Izin</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @else
                                        @if ($presensi->project_id == 0)
                                        <tr>
                                            <td align="center">{{ $presensi->nama }}</td>
                                            <td align="center">{{ $presensi->tgl }}</td>
                                            <td align="center">{{ $presensi->jam_masuk }} - {{ $presensi->jam_keluar }}</td>
                                            <td align="center">{{ ($presensi->project_id == 0) ? 'Semua Project' : $presensi->project->nama }}</td>
                                            <td align="center">
                                                <div class="btn-group">
                                                    <a href="{{ url('siswa/absensi/' . $presensi->kode) }}" class="btn btn-primary">Masuk</a>
                                                    <a href="{{ url('siswa/absensi_keluar/' . $presensi->kode) }}" class="btn btn-success">Keluar</a>
                                                    <a href="{{ url('siswa/izin/' . $presensi->kode) }}" class="btn btn-warning">Izin</a>
                                                </div>
                                            </td>
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