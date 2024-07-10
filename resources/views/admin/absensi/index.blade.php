@extends('template.main')
@section('content')
@include('template.nav.admin')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Daftar Absensi</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daftar Absensi</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">Data Absensi</h3>
                        <a href="{{ url('/admin/absensi/create') }}" class="btn btn-outline-primary m-b-10">Tambah data
                            Absensi</a>
                        @if ($data_absensi->count() > 0)
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered text-nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="th">#</th>
                                        <th class="th">Kegiatan</th>
                                        <th class="th">Tanggal</th>
                                        <th class="th">Jam</th>
                                        <th class="th">Proyek</th>
                                        <th class="th">Permohonan Izin</th>
                                        <th class="th">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_absensi as $absensi)
                                    <?php $now = \Carbon\Carbon::now() ?>
                                    <?php $mulai = \Carbon\Carbon::parse($absensi->tgl . ' ' . $absensi->jam_masuk) ?>
                                    <?php $selesai = \Carbon\Carbon::parse($absensi->tgl . ' ' . $absensi->jam_keluar) ?>

                                    <tr>
                                        <td align="center">{{ $loop->iteration }}</td>
                                        <td align="center">{{ $absensi->nama }}</td>
                                        <td align="center">{{ \Carbon\Carbon::parse($absensi->tgl)->formatLocalized('%A,
                                            %d %B %Y') }}</td>
                                        <td align="center">{{ $absensi->jam_masuk }} - {{ $absensi->jam_keluar }}</td>
                                        <td align="center">
                                            {{ ($absensi->project_id == 0) ? 'Semua Proyek' : $absensi->project->nama }}
                                        </td>
                                        <td align="center">
                                            <a class="btn btn-outline-secondary"
                                                href="{{ url('/admin/izin/' . $absensi->kode) }}"><span
                                                    class="badge badge-light px-2 mr-2">{{ $absensi->izin_count
                                                    }}</span> Karyawan</a>
                                        </td>
                                        <td align="center">
                                            <div class="btn-group">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-sm btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">ABSEN <span class="mr-1"></span></a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ url('/admin/absensi/' . $absensi->kode) }}">Masuk</a>
                                                    <a class="dropdown-item"
                                                        href="{{ url('/admin/absensi_keluar/' . $absensi->kode) }}">Keluar</a>
                                                </div>
                                            </div>
                                            
                                            @if ($now->diffInMinutes($mulai, false) < 0)
                                            <a class="btn btn-sm text-white btn-warning" style="cursor: not-allowed; opacity: 0.8;">EDIT</a>
                                            @else
                                            <a class="btn btn-sm
                                                btn-warning" href="{{ url('/admin/absensi/' . $absensi->kode . '/edit') }}"
                                                target="_blank" disabled>EDIT</a>
                                            @endif

                                            <a class="btn btn-sm btn-secondary"
                                                href="{{ url('/admin/detail/' . $absensi->kode) }}" target="_blank"
                                                title="detail"><i class="fa fa-search"></i></a>
                                            <a class="btn btn-sm btn-success"
                                                href="{{ url('/admin/cetak/' . $absensi->kode) }}" target="_blank"
                                                title="cetak"><i class="fa fa-print"></i></a>
                                                
                                            {{-- <div class="btn-group m-l-2">
                                                <a href="javascript:void(0);" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">Laporan</a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ url('/admin/cetak/' . $absensi->kode) }}"
                                                        target="_blank">PDF</a>
                                                    <form action="{{ url('/admin/absensi/' . $absensi->kode) }}"
                                                        method="post" style="display: inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="dropdown-item btn-hapus">
                                                            Hapus</button>
                                                    </form>
                                                </div>
                                            </div> --}}
                                            {{-- <a class="btn btn-secondary"
                                                href="{{ url('/admin/izin/' . $absensi->kode) }}">Permohonan Izin ( {{
                                                $absensi->izin_count }} )</a> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <a href="javascript:void(0);" class="btn btn-danger btn-block waves-effect waves-light">Tidak
                            Ada Data</a>
                        @endif
                    </div>
                </div>
            </div>
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
</div>

<script>
    const datatable_lang_id = "{{ asset('public/assets/plugins/datatables/i18n/id.json') }}";
        $(".btn-hapus").click(function(t){t.preventDefault(),Swal.fire({title:"Are you sure?",text:"Data yang akan dihapus tidak bisa dikembalikan",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Ya, hapus!",cancelButtonText:"Tidak"}).then(t=>{t.isConfirmed&&$(this).parent("form").submit()})}),$("table").DataTable({lengthMenu:[[-1,5,10,25,50],["Semua",5,10,25,50]],language:{url:datatable_lang_id}});
</script>
{!! session('pesan') !!}

@endsection