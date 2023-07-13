<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AdminKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kelas.index', [
            'judul' => 'Presensi QR BY Abduloh Malela | Data Kelas',
            'plugin_css' => '
                <link href="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
                <link href="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            ',
            'plugin_js' => '
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/jquery.dataTables.min.js"></script>
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/dataTables.bootstrap4.min.js"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'data_kelas' => Kelas::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kelas.create', [
            'judul' => 'Presensi QR BY Abduloh Malela | Tambah Kelas',
            'plugin_css' => '

            ',
            'plugin_js' => '
                
            ',
            'admin' => Admin::firstWhere('id', session('id')),
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
        $kelass = $request->nama;
        $data = [];
        foreach ($kelass as $kelas) {
            array_push($data, [
                'nama' => $kelas
            ]);
        }

        Kelas::insert($data);
        return redirect('/data_kelas')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "data disimpan!",
                    "success"
                )
            </script>
        ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kela)
    {
        // dd($kela);
        Kelas::where('id', $kela->id)
            ->update(['nama' => $request->nama]);

        return redirect('/data_kelas')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "data di ubah!",
                    "success"
                )
            </script>
        ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kela)
    {
        Kelas::destroy($kela->id);

        return redirect('/data_kelas')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "data di hapus!",
                    "success"
                )
            </script>
        ');
    }
}
