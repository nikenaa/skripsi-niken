@extends('template.main')
@section('content')
    @include('template.nav.admin')

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Students List</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">E-Presensi</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Students List</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h3 class="card-title font-16 mt-0">Students Data List</h3>
                            <a href="{{ url('/admin/siswa/create') }}" class="btn btn-outline-primary m-b-10">Tambah data Siswa</a>
                            @if ($data_siswa->count() > 0)
                                <table id="datatable" class="table table-bordered text-nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="th">#</th>
                                            <th class="th">NIM</th>
                                            <th class="th">NAMA</th>
                                            <th class="th">KELAS</th>
                                            <th class="th">JK</th>
                                            <th class="th">ACTIVE</th>
                                            <th class="th">IMAGE</th>
                                            <th class="th">OPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_siswa as $siswa)
                                            <tr>
                                                <td align="center">{{ $loop->iteration }}</td>
                                                <td align="center">{{ $siswa->no_induk }}</td>
                                                <td align="center">{{ $siswa->nama }}</td>
                                                <td align="center">
                                                    {{ $siswa->kelas->nama }}
                                                </td>
                                                <td align="center">{{ $siswa->jenis_kelamin }}</td>
                                                <td align="center">
                                                    @if ($siswa->is_active === 1)
                                                        <span class="badge badge-pill badge-primary">Yes</span>
                                                    @else
                                                        <span class="badge badge-pill badge-danger">No</span>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    <img src="{{ asset('assets/user/' . $siswa->foto) }}" alt="" class="rounded-circle thumb-sm">
                                                </td>
                                                <td align="center">
                                                    <a href="javascript:void(0);" class="btn btn-success btn-edit-siswa" data-toggle="modal" data-no_induk="{{ $siswa->no_induk }}" data-id="{{ $siswa->id }}" data-nama="{{ $siswa->nama }}" data-kelas_id="{{ $siswa->kelas_id }}" data-is_active="{{ $siswa->is_active }}" data-target="#modaleditsiswa"><i class="mdi mdi-cogs"></i></a>
                                                    
                                                    <form action="{{ url('/admin/siswa/' . $siswa->id) }}" method="post" style="display: inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

    <!-- MODAL EDIT -->
    <div id="modaleditsiswa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditsiswaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modaleditsiswaLabel">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body modal-body-admin">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="">No Induk</label>
                                    <input class="form-control" type="text" name="no_induk">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input class="form-control" type="text" name="nama">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="">Kelas</label>
                                    <select name="kelas_id" class="form-control">
                                        <!-- <option value="">Kelas</option> -->
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Aktif</label>
                            <select name="is_active" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- MODAL EDIT -->

    <script>
        $(".btn-edit-siswa").click(function(){var a=$(this).data("id"),t=$(this).data("no_induk"),i=$(this).data("nama"),n=$(this).data("kelas_id"),e=$(this).data("is_active"),a="{{ url('/admin/siswa') }}/"+a;$("input[name=nama]").val(i),$("input[name=no_induk]").val(t),$("select[name=kelas_id]").val(n),$("select[name=is_active]").val(e),$("#editForm").attr("action",a)}),$(".btn-hapus").click(function(a){a.preventDefault(),Swal.fire({title:"Are you sure?",text:"Data yang akan dihapus tidak bisa dikembalikan",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Ya, hapus!",cancelButtonText:"Tidak"}).then(a=>{a.isConfirmed&&$(this).parent("form").submit()})}),$("table").DataTable({scrollX:!0,lengthMenu:[[-1,5,10,25,50],["All",5,10,25,50]]});
    </script>
    {!! session('pesan') !!}

@endsection