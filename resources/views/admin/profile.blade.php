@extends('template.main')
@section('content')
    @include('template.nav.admin')
    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Profil</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Profil</li>
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
                            <img src="{{ asset('public/assets/user/' . $admin->foto) }}" alt="E-Presensi Abduloh" class="img-thumbnail" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title font-16 mt-0">Perbarui Profil</h4>
                            <form action="{{ url('/admin/' . $admin->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="edit" value="admin" required>
                                <input type="hidden" class="form-control" name="is_active" value="{{ $admin->is_active }}" required>

                                <div class="form-group">
                                    <label for="">Nama Pengguna</label>
                                    <input type="text" class="form-control" name="username" value="{{ $admin->username }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control" name="nama" value="{{ $admin->nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Foto</label><br>
                                    <input type="file" name="foto" id="foto-profile">
                                    <input type="hidden" name="foto_lama" value="{{ $admin->foto }}">
                                </div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title font-16 mt-0">Perbarui Password</h4>
                            <form action="{{ url('/password_admin/' . $admin->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Password Sekarang</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Password Baru</label>
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