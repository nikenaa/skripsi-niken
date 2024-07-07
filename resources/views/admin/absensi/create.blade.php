@extends('template.main')
@section('content')
@include('template.nav.admin')

<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">
                        @if (isset($absensi))
                            Edit Absensi
                        @else
                            Tambah Absensi
                        @endif
                    </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">E-Presensi</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/data_absensi') }}">Absensi</a></li>
                        <li class="breadcrumb-item active">
                            @if (isset($absensi))
                                Edit Absensi
                            @else
                                Tambah Absensi
                            @endif
                        </li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3 class="card-title font-16 mt-0">
                            @if (isset($absensi))
                                Form Edit Absensi
                            @else
                                Form Tambah Absensi
                            @endif
                        </h3>
                        {{-- <form action="{{ url('/admin/absensi') }}" method="POST"> --}}
                        <form action="{{ isset($absensi) ? url('/admin/absensi/' . $absensi->kode) : url('/admin/absensi') }}" method="POST">
                            @csrf
                            @if (isset($absensi))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Kegiatan</label>
                                        <input type="text" name="nama" value="{{ old('nama') ?  old('nama') : (isset($absensi) ? $absensi->nama : '') }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Proyek</label>
                                        @if (isset($absensi))
                                            <input readonly type="hidden" name="project_id" value="{{ $absensi->project->id }}" class="form-control">
                                            <input readonly type="text" name="" value="{{ $absensi->project->nama }}" class="form-control">
                                        @else
                                            <select name="project_id" id="" class="form-control" required>
                                                @if ($project->count() > 0)
                                                <option value="">Pilih Proyek</option>
                                                <option value="0">Semua Proyek</option>
                                                @foreach ($project as $k)
                                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                                @endforeach
                                                @else
                                                <option value="">Tidak Ada Data</option>
                                                @endif
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Tanggal</label>
                                        <input type="date" name="tgl" value="{{ old('tgl') ?  old('tgl') : (isset($absensi) ? $absensi->tgl : '') }}" class="form-control" required min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Jam Mulai</label>
                                        <input type="text" name="jam_masuk" value="{{ old('jam_masuk') ?  old('jam_masuk') : (isset($absensi) ? $absensi->jam_masuk : '') }}" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Jam Selesai</label>
                                        <input type="text" name="jam_keluar" value="{{ old('jam_keluar') ?  old('jam_keluar') : (isset($absensi) ? $absensi->jam_keluar : '') }}" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ url('/data_absensi') }}" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end container-fluid -->
    </div>
    <!-- end wrapper -->
</div>

<script>
    const timeOptions = {
        allowInputToggle: false,
        container: undefined,
        dateRange: false,
        debug: false,
        defaultDate: undefined,
        localization: {
            locale: 'id',
            format: 'HH:mm',
        },
        display: {
            icons : {
                time: 'fa fa-clock',
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down',
            },
            components: {
                calendar: false,
                date: false,
                month: false,
                year: false,
                decades: false,
                clock: true,
                hours: true,
                minutes: true,
                seconds: false,
                useTwentyfourHour: true,
            }
        }
    };

    const dateOptions = {
        allowInputToggle: false,
        container: undefined,
        dateRange: false,
        debug: false,
        defaultDate: undefined,
        localization: {
            locale: 'id',
            format: 'dddd, dd/MMM/yyyy',
        },
        display: {
            icons : {
                date: 'fa fa-calendar',
                previous: 'fa fa-angle-left',
                next: 'fa fa-angle-right',
                today: 'fa fa-calendar-check',
                clear: 'fa fa-trash-alt',
                close: 'fa fa-times',
            },
            components: {
                calendar: true,
                date: true,
                month: true,
                year: true,
                decades: true,
                clock: false,
                hours: false,
                minutes: false,
                seconds: false,
                useTwentyfourHour: false,
            }
        }
    };

    // tempusDominus jam_masuk
    const jam_masuk_picker = new tempusDominus.TempusDominus(document.querySelector('[name="jam_masuk"]'), timeOptions);
    const jam_keluar_picker = new tempusDominus.TempusDominus(document.querySelector('[name="jam_keluar"]'), timeOptions);

    // tempusDominus tgl
    // const tgl_picker = new tempusDominus.TempusDominus(document.querySelector('[name="tgl"]'), dateOptions);
</script>

{!! session('pesan') !!}

@endsection