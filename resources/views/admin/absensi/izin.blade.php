@extends('template.main')
@section('content')
    @include('template.nav.admin')
    

    
    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">LIst Permohonan Izin</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/data_absensi') }}">Presensi</a></li>
                            <li class="breadcrumb-item active">Permohonan Izin</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h4 class="card-title font-16 mt-0 mb-3">Permohonan Izin {{ $absensi->nama }}</h4>
                            @if ($list_izin->count() > 0)
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                        <thead>
                                            <tr align="center">
                                                <th class="th">#</th>
                                                <th class="th">NAMA</th>
                                                <th class="th">NO INDUK</th>
                                                <th class="th">PROJECT</th>
                                                <th class="th">IZIN</th>
                                                <th class="th">SUKET</th>
                                                <th class="th">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_izin as $izin)
                                                <tr align="center">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $izin->karyawan->nama }}</td>
                                                    <td>{{ $izin->karyawan->no_induk }}</td>
                                                    <td>{{ $izin->karyawan->project->nama }}</td>
                                                    <td>{{ $izin->keterangan }}</td>
                                                    <td>
                                                        <a href="{{ url('/suket_izin/' . $izin->suket) }}" class="btn btn-success">Unduh</a>
                                                    </td>
                                                    <td>
                                                        @if ($izin->izinkan == 0)
                                                            <a href="{{ url('/izinkan/' . $izin->id) }}" class="badge badge-warning btn-izinkan">Pending</a>
                                                        @else
                                                            <span class="badge badge-success">Di Izinkan</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn-block">Tidak Ada Data</a>
                                <br>
                            @endif
                            <a href="{{ url('/data_absensi') }}" class="btn btn-danger">kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->



    {!! session('pesan') !!}

@endsection