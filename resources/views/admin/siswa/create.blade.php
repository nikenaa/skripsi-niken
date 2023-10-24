@extends('template.main')
@section('content')
    @include('template.nav.admin')

    <div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Tambah Karyawan</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/data_karyawan') }}">Karyawan</a></li>
                        <li class="breadcrumb-item active">Tambah Karyawan</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">Form Tambah Karyawan</h3>
                        <button type="button" class="btn btn-outline-primary mt-2 mb-3 tambah-baris-siswa">Tambah Baris</button>
                        <form action="{{ url('/admin/siswa') }}" method="POST">
                            @csrf
                            <input type="hidden" name="additional" value="additional">
                            <div class="table-responsive">
                                <table class="table table-striped nowrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="th">NO INDUK</th>
                                            <th class="th">NAMA</th>
                                            <th class="th">PROJECT</th>
                                            <th class="th">JENIS KELAMIN</th>
                                            <th>OPSI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-data-siswa">
                                        <tr>
                                            <td><input type="text" name="no_induk[]" placeholder="Nomor Induk Karyawan" style="border: none; background: transparent; text-align: center;" autocomplete="off" required></td>
                                            <td><input type="text" name="nama[]" placeholder="nama" style="border: none; background: transparent; text-align: center;" autocomplete="off" required></td>
                                            <td>
                                                <select name="project_id[]" style="border: none; background: transparent; text-align: center;">
                                                    <option value="">Project</option>
                                                    @foreach ($project as $k)
                                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="jenis_kelamin[]" style="border: none; background: transparent; text-align: center;">
                                                    <option value="">Jenis Kelamin</option>
                                                    <option value="L">Laki - Laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ url('/data_karyawan') }}" class="btn btn-outline-warning mt-3">Back</a>
                                <button type=" submit" class="btn btn-outline-success mt-3 ml-1">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">WARNING!</h3>
                        <p>Mohon Untuk Mengisi Data dengan benar, terutama data yang sensitif seperi Nomor Induk. Ini bertujuan untuk mencegah malfunction atau error kedepannya</p>
                        <span class="blockquote-footer"></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end wrapper -->
</div>

<script>
    $('.tambah-baris-siswa').click(function() {
        var baru = `
            <tr>
                <td><input type="text" name="no_induk[]" placeholder="Nomor Induk Karyawan" style="border: none; background: transparent; text-align: center;" autocomplete="off" required></td>
                <td><input type="text" name="nama[]" placeholder="nama" style="border: none; background: transparent; text-align: center;" autocomplete="off" required></td>
                <td>
                    <select name="project_id[]" style="border: none; background: transparent; text-align: center;">
                        <option value="">Project</option>
                         @foreach ($project as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="jenis_kelamin[]" style="border: none; background: transparent; text-align: center;">
                        <option value="">Jenis Kelamin</option>
                        <option value="L">Laki - Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-xs remove-baris-siswa"><i class="mdi mdi-close-circle"></i></button>
                </td>
            </tr>
        `;
        $('#tbody-data-siswa').append(baru);
    });

    $('tbody').on('click', 'tr td button', function() {
        $(this).parents('tr').remove();
    });
</script>

@endsection