@if ($absensi->count() > 0)
    @php
        $ml = '';
    @endphp
    @foreach ($absensi as $absen)
        @if ($absen->izinkan === null)
            @if ($absen->absen_keluar === null)
                <div class="col-lg-3">
                    <a href="javascript:void(0);" class="friends-suggestions-list pb-4">
                        <div class="position-relative shadow p-2 rounded mt-2">
                            <div class="float-left mb-2 mr-2">
                                <img src="{{ asset('assets/user/' . $absen->siswa->foto) }}" alt="" class="rounded-circle thumb-md">
                            </div>
                            <div class="desc">
                                <h5 class="font-14 mb-1 text-dark">{{ $absen->siswa->nama }}</h5>
                                <small>Project : {{ $absen->siswa->project->nama }}</small><br>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @endif
    @endforeach
@else
    <a href="javascript:void(0);" class="btn btn-danger btn-block waves-effect waves-light">Tidak Ada Data</a>
@endif