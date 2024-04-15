@extends('template.main')
@section('content')
@include('template.nav.admin')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Tambah Admin</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Add Admin</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">Form Tambah Admin</h3>
                        <button type="button" class="btn btn-outline-primary mt-2 mb-3 tambah-baris-admin">Tambah
                            Baris</button>
                        <form action="{{ url('/admin') }}" method="POST">
                            @csrf
                            <input type="hidden" name="additional" value="additional">
                            <div class="table-responsive">
                                <table class="table table-striped nowrap" class="width:100% !Important;">
                                    <thead>
                                        <tr class="text-center">
                                            <th>NAMA</th>
                                            <th>NAMA PENGGUNA</th>
                                            <th>PASSWORD</th>
                                            <th>OPSI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-data-admin">
                                        <tr>
                                            <td><input type="text" name="nama[]" placeholder="nama"
                                                    style="border: none; background: transparent; text-align: center;"
                                                    required></td>
                                            <td><input type="text" name="username[]" placeholder="nama pengguna"
                                                    style="border: none; background: transparent; text-align: center;"
                                                    required></td>
                                            <td><input type="text" name="password[]" placeholder="password"
                                                    style="border: none; background: transparent; text-align: center;"
                                                    required></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ url('/admin') }}" class="btn btn-outline-warning mt-3">Back</a>
                                <button type=" submit" class="btn btn-outline-success mt-3 ml-1">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">WARNING!</h3>
                        <p>Pastikan untuk tidak memasukan data yang sama agar tidak terjadi error atau malfunction
                            kedepannya</p>
                        <span class="blockquote-footer"></span>
                    </div>
                </div>
            </div>
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
</div>
<script>
    // START::ADMIN
        $('.tambah-baris-admin').click(function() {
            var baru = `
                <tr>
                    <td>
                        <input type="text" name="nama[]" placeholder="nama" style="border: none; background: transparent; text-align: center;" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="text" name="username[]" placeholder="nama pengguna" style="border: none; background: transparent; text-align: center;" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="text" name="password[]" placeholder="password" style="border: none; background: transparent; text-align: center;" autocomplete="off" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xs remove-baris-admin"><i class="mdi mdi-close-circle"></i></button>
                    </td>
                </tr>
           `;
            $('#tbody-data-admin').append(baru);
        });

        $('tbody').on('click', 'tr td button', function() {
            $(this).parents('tr').remove();
        });
</script>

{!! session('pesan') !!}
@endsection