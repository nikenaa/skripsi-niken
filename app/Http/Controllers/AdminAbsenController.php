<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Project;
use App\Models\Karyawan;
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
            'judul' => 'Presensi QR | Data Absensi',
            'plugin_css' => '
                <link href="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
                <link href="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            ',
            'plugin_js' => '
                <script src="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/jquery.dataTables.min.js"></script>
                <script src="' . asset('assets/template/presensi-abdul') . '/plugins/datatables/dataTables.bootstrap4.min.js"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'data_absensi' => Absensi::withCount('izin')->orderBy('tgl', 'desc')->orderBy('jam_masuk', 'desc')->get(),
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
            'judul' => 'Presensi QR | Tambah Absensi',
            'plugin_css' => '
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
            ',
            'plugin_js' => '
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'project' => Project::all()
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
        if ($request->project_id == 0) {
            $karyawan = Karyawan::all();
        } else {
            $karyawan = Karyawan::where('project_id', $request->project_id)->get();
        }

        if ($karyawan->count() == 0) {
            return redirect('/admin/absensi/create')->with('pesan', '
                <script>
                    Swal.fire(
                        "Error!",
                        "data karyawan belum ada!",
                        "error"
                    )
                </script>
            ')->withInput();
        }

        $kode = Str::random(50);
        $absensi = [
            'kode' => $kode,
            'nama' => $request->nama,
            'project_id' => $request->project_id,
            'tgl' => $request->tgl,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
        ];

        $detail_absensi = [];
        foreach ($karyawan as $s) {
            array_push($detail_absensi, [
                'kode' => $kode,
                'karyawan_id' => $s->id,
            ]);
        }

        // check apakah absensi dengan tanggal yang sama dan jam_masuk sama sudah ada
        $cek_absensi = Absensi::where('project_id', $request->project_id)
            ->where('tgl', $request->tgl)
            ->where('jam_masuk', $request->jam_masuk)
            ->first();

        if ($cek_absensi) {
            return redirect('/admin/absensi/create')->with('pesan', '
                <script>
                    Swal.fire(
                        "Error!",
                        "absensi sudah ada! silahkan cek kembali!",
                        "error"
                    )
                </script>
            ')->withInput();
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
            'judul' => 'Presensi QR | Detail Absensi Masuk',
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
            'judul' => 'Presensi QR | Detail Absensi Keluar',
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
        return view('admin.absensi.create', [
            'judul' => 'Presensi QR | Edit Absensi',
            'plugin_css' => '
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css" crossorigin="anonymous">
            ',
            'plugin_js' => '
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js" crossorigin="anonymous"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'project' => $absensi->project->nama,
            'absensi' => $absensi,
        ]);
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
        if ($request->project_id == 0) {
            $karyawan = Karyawan::all();
        } else {
            $karyawan = Karyawan::where('project_id', $request->project_id)->get();
        }

        if ($karyawan->count() == 0) {
            return redirect('/admin/absensi/create')->with('pesan', '
                <script>
                    Swal.fire(
                        "Error!",
                        "data karyawan belum ada!",
                        "error"
                    )
                </script>
            ')->withInput();
        }

        $absensi = [
            'kode' => $absensi->kode,
            'nama' => $request->nama,
            'project_id' => $request->project_id,
            'tgl' => $request->tgl,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
        ];

        $old_detail_absensi = AbsensiDetail::where('kode', $absensi['kode'])->get();

        $detail_absensi = [];
        foreach ($karyawan as $s) {
            array_push($detail_absensi, [
                'kode' => $absensi['kode'],
                'karyawan_id' => $s->id,
                
                // get more data from absensi detail and if not exist then set to null 
                'absen_masuk' => $old_detail_absensi->where('karyawan_id', $s->id)->first()['absen_masuk'] ?? null,
                'telat' => $old_detail_absensi->where('karyawan_id', $s->id)->first()['telat'] ?? null,
                'absen_keluar' => $old_detail_absensi->where('karyawan_id', $s->id)->first()['absen_keluar'] ?? null,
                'izinkan' => $old_detail_absensi->where('karyawan_id', $s->id)->first()['izinkan'] ?? null,
                'suket' => $old_detail_absensi->where('karyawan_id', $s->id)->first()['suket'] ?? null,
                'keterangan' => $old_detail_absensi->where('karyawan_id', $s->id)->first()['keterangan'] ?? null,
            ]);
        }

        // Absensi::create($absensi);
        // AbsensiDetail::insert($detail_absensi);

        // update absensi 
        Absensi::where('kode', $absensi['kode'])->update($absensi);

        // update or create absensi detail
        foreach ($detail_absensi as $d) {
            AbsensiDetail::updateOrCreate(
                ['kode' => $d['kode'], 'karyawan_id' => $d['karyawan_id']],
                $d
            );
        }

        return redirect('/data_absensi')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "absensi diupdate!",
                    "success"
                )
            </script>
        ');
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
        $absensi_karyawan = AbsensiDetail::where('kode', $absensi->kode)
            ->whereNotNull('updated_at')
            ->get();

        $belum_absen = AbsensiDetail::where('kode', $absensi->kode)
            ->whereNull('absen_masuk')
            ->whereNull('izinkan')
            ->get();

        return view('admin.absensi.cetak', [
            'absensi' => $absensi,
            'absensi_karyawan' => $absensi_karyawan,
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
            'judul' => 'Presensi QR | Izin Absensi',
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
