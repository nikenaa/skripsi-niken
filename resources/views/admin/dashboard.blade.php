@extends('template.main')
@section('content')
    @include('template.nav.admin')
    <div class="wrapper">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">E-Presensi</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- end row -->
            </div>

            <div class="row">

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-account-supervisor-outline bg-primary  text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Karyawan</h5>
                            </div>
                            <h3 class="mt-4">{{ $karyawan->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-google-classroom bg-success text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Proyek</h5>
                            </div>
                            <h3 class="mt-4">{{ $project->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-clipboard-multiple-outline bg-warning text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Kegiatan</h5>
                            </div>
                            <h3 class="mt-4">{{ $absensi->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-heading p-4">
                            <div class="mini-stat-icon float-right">
                                <i class="mdi mdi-account-tie-outline bg-danger text-white"></i>
                            </div>
                            <div>
                                <h5 class="font-16">Admin</h5>
                            </div>
                            <h3 class="mt-4">{{ $data_admin->count() }}</h3>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end container-fluid -->
    </div>
{!! session('pesan') !!}
@endsection