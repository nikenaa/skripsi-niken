@extends('template.main')
@section('content')
    @include('template.nav.admin')

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Absensi List</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">E-Presensi</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Absensi List</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h3 class="card-title font-16 mt-0">Absensi Data List</h3>
                            <a href="{{ url('/admin/absensi/create') }}" class="btn btn-outline-primary m-b-10">Tambah data Absensi</a>
                            @if ($data_absensi->count() > 0)
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered text-nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="th">#</th>
                                                <th class="th">Nama Absensi</th>
                                                <th class="th">Tanggal</th>
                                                <th class="th">Jam</th>
                                                <th class="th">Project</th>
                                                <th class="th">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_absensi as $absensi)
                                                <tr>
                                                    <td align="center">{{ $loop->iteration }}</td>
                                                    <td align="center">{{ $absensi->nama }}</td>
                                                    <td align="center">{{ $absensi->tgl }}</td>
                                                    <td align="center">{{ $absensi->jam_masuk }} - {{ $absensi->jam_keluar }}</td>
                                                    <td align="center">
                                                        {{ ($absensi->project_id == 0) ? 'Semua Project' : $absensi->project->nama }}
                                                    </td>
                                                    <td align="center">

                                                        <div class="btn-group">
                                                            <a href="javascript:void(0);" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Absen</a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{ url('/admin/absensi/' . $absensi->kode) }}">Masuk</a>
                                                                <a class="dropdown-item" href="{{ url('/admin/absensi_keluar/' . $absensi->kode) }}">Keluar</a>
                                                            </div>
                                                        </div>
                                                        <div class="btn-group m-l-2">
                                                            <a href="javascript:void(0);" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{ url('/admin/cetak/' . $absensi->kode) }}" target="_blank">PDF</a>
                                                                <form action="{{ url('/admin/absensi/' . $absensi->kode) }}" method="post" style="display: inline">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item btn-hapus"> Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <a class="btn btn-primary" href="{{ url('/admin/izin/' . $absensi->kode) }}" >Permohonan Izin ( {{ $absensi->izin_count }} )</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <a href="javascript:void(0);" class="btn btn-danger btn-block waves-effect waves-light">Tidak Ada Data</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!-- end container-fluid -->
        </div>
        <!-- end wrapper -->
    </div>

    <script>
        $(".btn-hapus").click(function(t){t.preventDefault(),Swal.fire({title:"Are you sure?",text:"Data yang akan dihapus tidak bisa dikembalikan",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Ya, hapus!",cancelButtonText:"Tidak"}).then(t=>{t.isConfirmed&&$(this).parent("form").submit()})}),$("table").DataTable({lengthMenu:[[-1,5,10,25,50],["All",5,10,25,50]]});
    </script>
    {!! session('pesan') !!}

@endsection