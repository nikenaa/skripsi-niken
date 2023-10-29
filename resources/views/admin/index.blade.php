@extends('template.main')
@section('content')
@include('template.nav.admin')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Admin List</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Admin List</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">Admin Data List</h3>
                        <a href="{{ url('admin/create') }}" class="btn btn-outline-primary m-b-10">Tambah data Admin</a>
                        @if ($data_admin->count() > 0)
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="th">#</th>
                                        <th class="th">NAMA</th>
                                        <th class="th">USERNAME</th>
                                        <th class="th">DATE CREATED</th>
                                        <th class="th">ACTIVE</th>
                                        <th class="th">IMAGE</th>
                                        <th class="th">OPTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_admin as $dm)
                                        <tr>
                                            <td align="center">{{ $loop->iteration; }}</td>
                                            <td align="center">{{ $dm->nama; }}</td>
                                            <td align="center">{{ $dm->username; }}</td>
                                            <td align="center">{{ $dm->created_at }}</td>
                                            <td align="center">
                                                @if ($dm->is_active == 1)
                                                    <span class="badge badge-pill badge-primary">Yes</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">No</span> 
                                                @endif
                                            </td>
                                            <td align="center">
                                                <img src="{{ asset('assets/user/' . $dm->foto) }}" alt="" class="rounded-circle thumb-sm">
                                            </td>
                                            <td align="center">
                                                @if ($dm->id == session('id'))
                                                    <a href="javascript:void(0);" class="btn btn-primary">You</a>
                                                @else
                                                <a href="javascript:void(0);" class="btn btn-success btn-edit-admin" data-toggle="modal" data-id="{{ $dm->id }}" data-nama="{{ $dm->nama }}" data-username="{{ $dm->username }}" data-password="{{ $dm->password }}" data-is_active="{{ $dm->is_active }}" data-target="#modaleditadmin"><i class="mdi mdi-cogs"></i></a>
                                                <form action="{{ url('/admin/'. $dm->id) }}" method="post" class="hapus-form" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light">Tidak Ada Data</a>
                        @endif
                    </div>
                </div>
            </div>
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
</div>

<!-- MODAL EDIT -->
<div id="modaleditadmin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditadminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" id="editForm">
                @method('PUT')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modaleditadminLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body modal-body-admin">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="hidden" name="edit" value="admins" required>
                        <input class="form-control" type="text" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="">Username</label>
                        <input class="form-control" type="text" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input class="form-control" type="text" name="password" required>
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
    $(".btn-edit-admin").click(function(){var a=$(this).data("id"),t=$(this).data("nama"),n=$(this).data("username"),i=$(this).data("password"),e=$(this).data("is_active"),a="{{ url('/admin') }}/"+a;$("input[name=nama]").val(t),$("input[name=username]").val(n),$("input[name=password]").val(i),$("select[name=is_active]").val(e),$("#editForm").attr("action",a)}),$(".btn-hapus").click(function(a){a.preventDefault(),Swal.fire({title:"Are you sure?",text:"Data yang akan dihapus tidak bisa dikembalikan",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Ya, hapus!",cancelButtonText:"Tidak"}).then(a=>{a.isConfirmed&&$(this).parent("form").submit()})}),$("table").DataTable({scrollX:!0,lengthMenu:[[-1,5,10,25,50],["All",5,10,25,50]]});
</script>

{!! session('pesan') !!}
@endsection