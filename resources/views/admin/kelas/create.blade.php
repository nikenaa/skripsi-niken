@extends('template.main')
@section('content')
@include('template.nav.admin')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Tambah Project</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/data_project') }}">Project</a></li>
                        <li class="breadcrumb-item active">Add Project</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">Form Tambah Project</h3>
                        <button type="button" class="btn btn-outline-primary mt-2 mb-3 tambah-baris-kelas">Tambah Baris</button>
                        <form action="{{ url('/admin/project') }}" method="POST">
                            @csrf
                            <input type="hidden" name="additional" value="additional">
                            <div class="table-responsive">
                                <table class="table table-striped nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>NAMA</th>
                                            <th>OPSI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-data-kelas">
                                        <tr>
                                            <td><input type="text" name="nama[]" placeholder="Nama Project" style="border: none; background: transparent; text-align: center;" autocomplete="off" required></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ url('/data_project') }}" class="btn btn-outline-warning mt-3">Back</a>
                                <button type="submit" class="btn btn-outline-success mt-3 ml-1">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
</div>

<script>
    // HAPUS ROW
        $('tbody').on('click', 'tr td button', function() {
            $(this).parents('tr').remove();
        });

        // START::PROJECT
        $('.tambah-baris-kelas').click(function() {
            var baru = `
                <tr>
                    <td>
                        <input type="text" name="nama[]" placeholder="Nama Project" style="border: none; background: transparent; text-align: center;" autocomplete="off" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xs remove-baris-kelas"><i class="mdi mdi-close-circle"></i></button>
                    </td>
                </tr>
           `;
            $('#tbody-data-kelas').append(baru);
        });
</script>

@endsection