<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AbsensiDetail;
use Illuminate\Support\Facades\Storage;

class AdminAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.absensi.index', [
            'judul' => 'Presensi QR BY Abduloh Malela | Data Absensi',
            'plugin_css' => '
                <link href="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
                <link href="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            ',
            'plugin_js' => '
                <script src="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/jquery.dataTables.min.js"></script>
                <script src="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/dataTables.bootstrap4.min.js"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'data_absensi' => Absensi::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.absensi.create', [
            'judul' => 'Presensi QR BY Abduloh Malela | Tambah Absensi',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'kelas' => Kelas::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->kelas_id == 0) {
            $siswa = Siswa::all();
        } else {
            $siswa = Siswa::where('kelas_id', $request->kelas_id)
                ->get();
        }
        if ($siswa->count() == 0) {
            return redirect('/admin/absensi/create')->with('pesan', '
                <script>
                    Swal.fire(
                        "Error!",
                        "data siswa belum ada!",
                        "error"
                    )
                </script>
            ')->withInput();
        }

        $kode = Str::random(50);
        $absensi = [
            'kode' => $kode,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'tgl' => $request->tgl,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
        ];
        $detail_absensi = [];
        foreach ($siswa as $s) {
            array_push($detail_absensi, [
                'kode' => $kode,
                'siswa_id' => $s->id,
            ]);
        }
        Absensi::create($absensi);
        AbsensiDetail::insert($detail_absensi);
        return redirect('/data_absensi')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "absensi dibuat!",
                    "success"
                )
            </script>
        ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show(Absensi $absensi)
    {
        return view('admin.absensi.show', [
            'judul' => 'Presensi QR BY Abduloh Malela | Detail Absensi Masuk',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                <script src="' . asset('assets/template/presensi-abdul') . '/plugins/qrcode/qrcode.js"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'absensi' => $absensi
        ]);
    }
    public function show_keluar(Absensi $absensi)
    {
        return view('admin.absensi.show-keluar', [
            'judul' => 'Presensi QR BY Abduloh Malela | Detail Absensi Keluar',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                <script src="' . asset('assets/template/presensi-abdul') . '/plugins/qrcode/qrcode.js"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'absensi' => $absensi
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
        AbsensiDetail::where('kode', $absensi->kode)->delete();
        Absensi::destroy($absensi->id);
        return redirect('/data_absensi')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "absensi dihapus!",
                    "success"
                )
            </script>
        ');
    }

    public function sudah_absen(Request $request)
    {
        $absensi = AbsensiDetail::where('kode', $request->content)
            ->whereNotNull('absen_masuk')
            ->get();
        $izin = AbsensiDetail::where('kode', $request->content)
            ->whereNotNull('izinkan')
            ->get();
        return view('admin.absensi.sudah_absen', [
            'absensi' => $absensi,
            'izin' => $izin,
        ]);
    }
    public function belum_absen(Request $request)
    {
        $absensi = AbsensiDetail::where('kode', $request->content)
            ->whereNull('absen_masuk')
            ->get();
        return view('admin.absensi.belum_absen', [
            'absensi' => $absensi
        ]);
    }
    public function cetakqr($kode)
    {
        return view('admin.absensi.cetak-qr', [
            'kode' => $kode,
            'absensi' => Absensi::firstWhere('kode', $kode)
        ]);
    }
    public function cetak(Absensi $absensi)
    {
        $absensi_siswa = AbsensiDetail::where('kode', $absensi->kode)
            ->whereNotNull('updated_at')
            ->get();

        $belum_absen = AbsensiDetail::where('kode', $absensi->kode)
            ->whereNull('absen_masuk')
            ->whereNull('izinkan')
            ->get();

        return view('admin.absensi.cetak', [
            'absensi' => $absensi,
            'absensi_siswa' => $absensi_siswa,
            'belum_absen' => $belum_absen
        ]);
    }
    public function sudah_absen_keluar(Request $request)
    {
        $absensi = AbsensiDetail::where('kode', $request->content)
            ->whereNotNull('absen_keluar')
            ->get();
        $izin = AbsensiDetail::where('kode', $request->content)
            ->whereNotNull('izinkan')
            ->get();
        return view('admin.absensi.sudah_absen_keluar', [
            'absensi' => $absensi,
            'izin' => $izin,
        ]);
    }
    public function belum_absen_keluar(Request $request)
    {
        $absensi = AbsensiDetail::where('kode', $request->content)
            ->whereNotNull('absen_masuk')
            ->get();
        return view('admin.absensi.belum_absen_keluar', [
            'absensi' => $absensi
        ]);
    }
    public function izin(Absensi $absensi)
    {
        $izin = AbsensiDetail::where('kode', $absensi->kode)
            ->whereNotNull('izinkan')
            ->get();

        return view('admin.absensi.izin', [
            'judul' => 'Presensi QR BY Abduloh Malela | Izin Absensi',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'absensi' => $absensi,
            'list_izin' => $izin
        ]);
    }
    public function suket($suket)
    {
        return Storage::download('assets/izin/' . $suket);
    }
    public function izinkan(AbsensiDetail $absensidetail)
    {
        AbsensiDetail::where('id', $absensidetail->id)
            ->update(['izinkan' => 1]);

        return redirect('/admin/izin/' . $absensidetail->kode)->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "berhasil di izinkan!",
                    "success"
                )
            </script>
        ');
    }
}
