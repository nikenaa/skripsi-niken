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
    <h2 style="text-align: center;">E-PRESENSI BY ABDULOH<br><small>Built With Laravel 8 & PHP 8</small></h2>
    <p style="text-align: center;">jln. Samping Toko Bunga Ino RT 70 RW 50 Konoha Barat</p>
    <hr>
    <center>
        <table width="100%" class="text-center">
            <tr>
                <th style="">Nama Absen</th>
                <th style="">Project</th>
                <th style="">Tanggal</th>
                <th style="">Jam</th>
            </tr>
            <tr>
                <td style=" background: trasparent">{{ $absensi->nama }}</td>
                <td style=" background: trasparent">{{ ($absensi->project_id == 0) ? 'Semua Project' : $absensi->project->nama }}</td>
                <td style=" background: trasparent">{{ $absensi->tgl }}</td>
                <td style=" background: trasparent">{{ $absensi->jam_masuk }} - {{ $absensi->jam_keluar }}</td>
            </tr>
        </table>
    </center>
    <hr>
    
    @if ($absensi_siswa->count() > 0)
        <h4 class="mt-4" style="text-align: center;">List Sudah Presensi</h4>
        <table class="table text-center" width="100%">
            <tr>
                <th>NAMA KARYAWAN</th>
                <th>NO INDUK</th>
                <th>PROJECT</th>
                <th>ABSEN MASUK</th>
                <th>STATUS</th>
                <th>ABSEN PULANG</th>
                <th>KET</th>
            </tr>
            @foreach ($absensi_siswa as $absen)
                @if ($absen->absen_masuk !== null || $absen->izinkan !== null)
                    <tr>
                        <td>{{ $absen->siswa->nama }}</td>
                        <td>{{ $absen->siswa->no_induk }}</td>
                        <td>{{ $absen->siswa->project->nama }}</td>
                        <td>{{ ($absen->absen_masuk == null) ? '-' : Str::substr($absen->absen_masuk, 11, 5) }}</td>
                        <td>
                            @if ($absen->telat == 0) sukses @endif
                            @if ($absen->telat == 1) terlambat @endif
                            @if ($absen->telat == null) izin @endif
                        </td>
                        <td>
                            @if ($absen->izinkan !== null)
                                -
                            @else
                                {{ ($absen->absen_keluar == null) ? 'belum absen' : Str::substr($absen->absen_keluar, 11, 5) }}
                            @endif
                        </td>
                        <td>{{ ($absen->keterangan == null) ? '-' : $absen->keterangan }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    @endif
    
    @if ($belum_absen->count() > 0)
        <h4 class="mt-4" style="text-align: center;">List Belum Presensi</h4>
        <table class="table text-center" width="100%">
            <tr>
                <th>NAMA KARYAWAN</th>
                <th>NO INDUK</th>
                <th>PROJECT</th>
            </tr>
            @foreach ($belum_absen as $absen)
                <tr>
                    <td>{{ $absen->siswa->nama }}</td>
                    <td>{{ $absen->siswa->no_induk }}</td>
                    <td>{{ $absen->siswa->project->nama }}</td>
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