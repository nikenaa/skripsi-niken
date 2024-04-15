<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report {{ $absensi->nama }}</title>
    <link href="{{ asset('assets/template/presensi-abdul/horizontal') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <style>
        /* body{
            font-family: sans-serif;
        }
        table{
            border: 0.01px solid #000;
        }
        tr td{
            text-align: center;
            border: 0.01px solid #000;
            font-weight: 20;
        }
        tr th{
            border: 0.01px solid #000;
        }
        input[type=text] {
            border: none;
            background: transparent;
        } */
    </style>
</head>
<body>
    <h2 style="text-align: center;">PT DCITS<br><small>Digital China Information Service Company Ltd.</small></h2>
    <p style="text-align: center;">Palma One Floor.6, 605, H.R Rasuna Said Street RT/RW. 008/004, Kuningan Timur, Setiabudi, Jakarta Selatan, DKI Jakarta 12950</p>
    <hr>
    {{-- <center>
        <table width="100%" class="text-center">
            <tr>
                <th style="">Nama Absen</th>
                <th style="">Proyek</th>
                <th style="">Tanggal</th>
                <th style="">Jam</th>
            </tr>
            <tr>
                <td style=" background: trasparent">{{ $absensi->nama }}</td>
                <td style=" background: trasparent">{{ ($absensi->project_id == 0) ? 'Semua Proyek' : $absensi->project->nama }}</td>
                <td style=" background: trasparent">{{ $absensi->tgl }}</td>
                <td style=" background: trasparent">{{ $absensi->jam_masuk }} - {{ $absensi->jam_keluar }}</td>
            </tr>
        </table>
    </center> --}}

    <table class="table table-sm table-compact">
        <tr>
            <th width="200px">Kegiatan</th>
            <td>{{ $absensi->nama }}</td>
        </tr>
        <tr>
            <th width="200px">Proyek</th>
            <td>{{ ($absensi->project_id == 0) ? 'Semua Proyek' : $absensi->project->nama }}</td>
        </tr>
        <tr>
            <th width="200px">Tanggal</th>
            <td>{{ $absensi->tgl }}</td>
        </tr>
        <tr>
            <th width="200px">Jam</th>
            <td>{{ $absensi->jam_masuk }} - {{ $absensi->jam_keluar }}</td>
        </tr>
        <tr>
            <th width="200px">Jumlah Peserta</th>
            <td>{{ $absensi_karyawan->count() }}</td>
        </tr>
    </table>
    
    @if ($absensi_karyawan->count() > 0)
        <h4 class="mt-4" style="text-align: center;">Daftar Karyawan Sudah Absen</h4>
        <table class="table text-center" width="100%">
            <tr>
                <th>NO</th>
                <th>NIK</th>
                <th>NAMA</th>
                {{-- <th>PROYEK</th> --}}
                <th>WAKTU PRESENSI</th>
                <th>KETERANGAN</th>
                <th>WAKTU KELUAR</th>
                {{-- <th>KET</th> --}}
            </tr>
            @foreach ($absensi_karyawan as $absen)
                @if ($absen->absen_masuk !== null || $absen->izinkan !== null)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $absen->karyawan->no_induk }}</td>
                        <td>{{ $absen->karyawan->nama }}</td>
                        {{-- <td>{{ $absen->karyawan->project->nama }}</td> --}}
                        <td>{{ ($absen->absen_masuk != null) ? Str::substr($absen->absen_masuk, 11, 5) : ($absen->izinkan !== null && $absen->izinkan == 0 ? 'tidak hadir' : '-') }}</td>
                        <td>
                            <?php 
                                $masuk = Str::substr($absen->absen_masuk, 11, 5);
                                $jam_masuk = $absensi->jam_masuk;
                                
                                $telat = strtotime($masuk) - strtotime($jam_masuk);
                                $telat = $telat / 60;
                            ?>
                            @if ($absen->telat == 1) terlambat ( {{ $telat }} menit ) @endif
                            @if ($absen->izinkan !== null && $absen->izinkan == 1) tidak @endif
                            @if ($absen->izinkan !== null && $absen->izinkan == 0) tidak hadir @endif
                        </td>
                        <td>
                            @if ($absen->izinkan !== null && $absen->izinkan == 0)
                                tidak hadir
                            @elseif ($absen->izinkan !== null && $absen->izinkan == 1)
                                -
                            @else
                                {{ ($absen->absen_keluar == null) ? 'belum absen' : Str::substr($absen->absen_keluar, 11, 5) }}
                            @endif
                        </td>
                        {{-- <td>{{ ($absen->keterangan == null) ? '-' : $absen->keterangan }}</td> --}}
                    </tr>
                @endif
            @endforeach
        </table>
    @endif
    
    @if ($belum_absen->count() > 0)
        <h4 class="mt-4" style="text-align: center;">Daftar Karyawan Belum Absen</h4>
        <table class="table text-center" width="100%">
            <tr>
                <th>NO</th>
                <th>NAMA KARYAWAN</th>
                <th>NO INDUK</th>
                {{-- <th>PROYEK</th> --}}
            </tr>
            @foreach ($belum_absen as $absen)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $absen->karyawan->nama }}</td>
                    <td>{{ $absen->karyawan->no_induk }}</td>
                    {{-- <td>{{ $absen->karyawan->project->nama }}</td> --}}
                </tr>
            @endforeach
        </table>
    @endif

    <script>
        setTimeout(() => {
            window.print();
        }, 1000);
    </script>
</body>
</html>