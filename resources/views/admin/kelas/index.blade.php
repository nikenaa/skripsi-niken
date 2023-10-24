@extends('template.main')
@section('content')
@include('template.nav.admin')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Projects</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item active">Projects</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0">Project List</h4>
                        <a href="{{ url('/admin/kelas/create') }}" class="btn btn-outline-primary m-b-10">Tambah Project</a>
                        @if ($data_project->count() > 0)
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered nowrap" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="th">#</th>
                                            <th class="th">NAMA</th>
                                            <th class="th">OPTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_project as $project)
                                            <tr>
                                                <td align="center">{{ $loop->iteration }}</td>
                                                <td align="center">{{ $project->nama; }}</td>
                                                <td align="center">
                                                    <a href="javascript:void(0);" class="btn btn-success btn-edit-class" data-toggle="modal" data-id="{{ $project->id }}" data-nama="{{ $project->nama }}" data-target="#modaleditclass"><i class="mdi mdi-cogs"></i></a>
                                                    <form action="{{ url('/admin/kelas/' . $project->id) }}" method="post" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn-block">Tidak Ada Data</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>
<!-- end wrapper -->

<!-- MODAL EDIT -->
<div id="modaleditclass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditclassLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modaleditclassLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body modal-body-admin">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input class="form-control" type="text" name="nama" required>
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
    $(".btn-edit-class").click(function(){var a=$(this).data("id"),t=$(this).data("nama"),a="{{ url('/admin/kelas') }}/"+a;$("input[name=nama]").val(t),$("#editForm").attr("action",a)}),$(".btn-hapus").click(function(a){a.preventDefault(),Swal.fire({title:"Are you sure?",text:"Data yang akan dihapus tidak bisa dikembalikan",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Ya, hapus!",cancelButtonText:"Tidak"}).then(a=>{a.isConfirmed&&$(this).parent("form").submit()})}),$("table").DataTable({scrollX:!0,lengthMenu:[[-1,5,10,25,50],["All",5,10,25,50]]});
</script>
    {!! session('pesan') !!}

@endsection