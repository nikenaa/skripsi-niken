@if ($absensi->count() > 0 || $izin->count() > 0)
    @foreach ($absensi as $absen)
        <div class="col-sm-3">
            <a href="javascript:void(0);" class="friends-suggestions-list">
                <div class="position-relative shadow rounded mt-2">
                    <div class="float-left mb-2 mr-2 ml-2 mt-1">
                        <img src="{{ asset('public/assets/user/' . $absen->karyawan->foto) }}" alt="" class="rounded-circle thumb-md mt-2">
                    </div>
                    <div class="desc">
                        <h5 class="font-14 mb-1 text-dark pt-3">{{ $absen->karyawan->nama }}</h5>
                        <small>Proyek : {{ $absen->karyawan->project->nama }}</small><br><br>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
    @foreach ($izin as $key => $i)
        <div class="col-sm-3 ">
            <a href="javascript:void(0);" class="friends-suggestions-list">
                <div class="position-relative shadow rounded mt-2">
                    <div class="float-left mb-2 mr-2 ml-2 mt-1">
                        <img src="{{ asset('public/assets/user/' . $i->karyawan->foto) }}" alt="" class="rounded-circle thumb-md mt-2">
                    </div>
                    <div class="desc">
                        <h5 class="font-14 mb-1 text-dark pt-2">{{ $i->karyawan->nama }}</h5>
                        <small>Proyek : {{ $i->karyawan->project->nama }}</small><br>
                        @if ($i->izinkan == 1)
                            <span class="badge badge-primary mb-2">Izin</span>
                        @endif
                        @if ($i->izinkan == 0)
                            <span class="badge badge-warning mb-2">Pending Izin</span>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@else
    <a href="javascript:void(0);" class="btn btn-danger btn-block waves-effect waves-light">Tidak Ada Data</a>
@endif