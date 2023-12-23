<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\AbsensiDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class SiswaAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $absensi_all = Absensi::all();
        return view('siswa.absensi.index', [
            'judul' => 'Presensi QR | Absensi',
            'plugin_css' => '
                <link href="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
                <link href="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            ',
            'plugin_js' => '
                <script src="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/jquery.dataTables.min.js"></script>
                <script src="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/dataTables.bootstrap4.min.js"></script>
            ',
            'karyawan' => Karyawan::firstWhere('id', session('id')),
            'presensi_list' => $absensi_all,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show(Absensi $absensi)
    {
        $absensi_karyawan = AbsensiDetail::where('kode', $absensi->kode)
            ->where('karyawan_id', session('id'))
            ->toSql();
        dd($absensi->kode);
        return view('siswa.absensi.show', [
            'judul' => 'Presensi QR | Absensi Masuk',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                <script src="' . asset('assets') . '/qr/adapter.min.js"></script>
                <script src="' . asset('assets/template/presensi-abdul/horizontal/assets/js/core.min.js') . '"></script>
            ',
            'karyawan' => Karyawan::firstWhere('id', session('id')),
            'absensi' => $absensi,
            'absensi_karyawan' => $absensi_karyawan,
        ]);
    }
    public function show_keluar(Absensi $absensi)
    {
        $absensi_karyawan = AbsensiDetail::where('kode', $absensi->kode)
            ->where('karyawan_id', session('id'))
            ->first();

        return view('siswa.absensi.show-keluar', [
            'judul' => 'Presensi QR | Absensi Keluar',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                <script src="' . asset('assets') . '/qr/adapter.min.js"></script>
                <script src="' . asset('assets/template/presensi-abdul/horizontal/assets/js/core.min.js') . '"></script>
            ',
            'karyawan' => Karyawan::firstWhere('id', session('id')),
            'absensi' => $absensi,
            'absensi_karyawan' => $absensi_karyawan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absensi $absensi)
    {
        //
    }

    public function absen_masuk(Request $request)
    {
        $absensi = Absensi::firstWhere('kode', $request->content);
        if ($absensi == null) {
            return 'error';
        } else {
            $waktu_sekarang = date('Y-m-d H:i:s', time());
            $jam_masuk = $absensi->tgl . ' ' . $absensi->jam_masuk;
            if (strtotime($waktu_sekarang) > strtotime($jam_masuk)) {
                $telat = 1;
            } else {
                $telat = 0;
            }

            $data = [
                'absen_masuk' => $waktu_sekarang,
                'telat' => $telat,
            ];

            AbsensiDetail::where('kode', $absensi->kode)
                ->where('karyawan_id', session('id'))
                ->update($data);

            return 'success';
        }
    }
    public function absen_keluar(Request $request)
    {
        $absensi = Absensi::firstWhere('kode', $request->content);
        if ($absensi == null) {
            return 'error';
        } else {
            $waktu_sekarang = date('Y-m-d H:i:s', time());
            $data = [
                'absen_keluar' => $waktu_sekarang
            ];

            AbsensiDetail::where('kode', $absensi->kode)
                ->where('karyawan_id', session('id'))
                ->update($data);

            return 'success';
        }
    }
    public function izin(Absensi $absensi)
    {
        $absensi_karyawan = AbsensiDetail::where('kode', $absensi->kode)
            ->where('karyawan_id', session('id'))
            ->first();
        return view('siswa.absensi.izin', [
            'judul' => 'Presensi QR | Izin Absensi',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                
            ',
            'karyawan' => Karyawan::firstWhere('id', session('id')),
            'absensi' => $absensi,
            'absensi_karyawan' => $absensi_karyawan,
        ]);
    }
    public function izin_(Absensi $absensi, Request $request)
    {
        $data['izinkan'] = 0;
        $data['suket'] = str_replace('assets/izin/', '', $request->file('suket')->store('assets/izin'));
        $data['keterangan'] = $request->keterangan;

        AbsensiDetail::where('kode', $absensi->kode)
            ->where('karyawan_id', session('id'))
            ->update($data);

        return redirect('/siswa/izin/' . $absensi->kode)->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "permohonan izin berhasil dikirim!",
                    "success"
                )
            </script>
        ');
    }
    public function suket($suket)
    {
        return Storage::download('assets/izin/' . $suket);
    }
}
