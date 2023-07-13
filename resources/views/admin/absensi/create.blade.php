@extends('template.main')
@section('content')
    @include('template.nav.admin')

    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Tambah Absensi</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">E-Presensi</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/data_absensi') }}">Absensi</a></li>
                            <li class="breadcrumb-item active">Add Absensi</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <h3 class="card-title font-16 mt-0">Form Tambah Absensi</h3>
                            <form action="{{ url('/admin/absensi') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Nama Absensi</label>
                                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Kelas</label>
                                            <select name="kelas_id" id="" class="form-control" required>
                                                @if ($kelas->count() > 0)
                                                    <option value="">Pilih Kelas</option>
                                                    <option value="0">Semua Kelas</option>
                                                    @foreach ($kelas as $k)
                                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">Tidak Ada Data</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Tanggal</label>
                                            <input type="date" name="tgl" value="{{ old('tgl') }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Jam Mulai</label>
                                            <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Jam Selesai</label>
                                            <input type="time" name="jam_keluar" value="{{ old('jam_keluar') }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ url('/admin/data_absensi') }}" class="btn btn-warning">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- end container-fluid -->
        </div>
        <!-- end wrapper -->
    </div>


    {!! session('pesan') !!}

@endsection