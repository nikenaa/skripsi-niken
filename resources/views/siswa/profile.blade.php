@extends('template.main')
@section('content')
@include('template.nav.siswa')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Profile</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Karyawan</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0"></h4>
                        <img src="{{ asset('assets/user/' . $karyawan->foto) }}" alt="E-Presensi Abduloh" class="img-thumbnail" style="width: 100%">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0">Update My Profile</h4>
                        <form action="{{ url('/siswa_profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">No Induk</label>
                                        <input type="text" name="no_induk" value="{{ $karyawan->no_induk }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" name="nama" value="{{ $karyawan->nama }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Project</label>
                                        <input type="text" name="project_id" value="{{ $karyawan->project->nama }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Gender</label>
                                        <select name="jenis_kelamin" class="form-control">
                                            <?php if ($karyawan->jenis_kelamin == 'P') : ?>
                                                <option value="L">Laki- Laki</option>
                                                <option value="P" selected>Perempuan</option>
                                            <?php else : ?>
                                                <option value="L" selected>Laki- Laki</option>
                                                <option value="P">Perempuan</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" value="{{ $karyawan->tgl_lahir }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" value="{{ $karyawan->tempat_lahir }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">Foto</label>
                                        <input type="file" name="foto">
                                        <input type="hidden" name="foto_lama" value="{{ $karyawan->foto }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title font-16 mt-0">Update Password</h4>
                        <form action="{{ url('/siswa/password/' . $karyawan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Current Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="">New Password</label>
                                <input type="password" class="form-control" name="password2" required>
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container-fluid -->
</div>

{!! session('pesan') !!}
@endsection