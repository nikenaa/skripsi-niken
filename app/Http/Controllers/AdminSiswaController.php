<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AdminSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_siswa()
    {
        return view('admin.siswa.index', [
            'judul' => 'Presensi QR BY Abduloh Malela | Data Siswa',
            'plugin_css' => '
                <link href="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
                <link href="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            ',
            'plugin_js' => '
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/jquery.dataTables.min.js"></script>
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/dataTables.bootstrap4.min.js"></script>
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/dataTables.responsive.min.js"></script>
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/responsive.bootstrap4.min.js"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'data_siswa' => Siswa::all(),
            'kelas' => Kelas::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.siswa.create', [
            'judul' => 'Presensi QR BY Abduloh Malela | Tambah Siswa',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'data_siswa' => Siswa::all(),
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
        $no_induk = $request->no_induk;
        $data = [];
        $i = 0;
        $created_at = now();
        foreach ($no_induk as $ni) {
            array_push($data, [
                'no_induk'=> $ni,
                'nama' => $request->nama[$i],
                'kelas_id' => $request->kelas_id[$i],
                'jenis_kelamin' => $request->jenis_kelamin[$i],
                'username' => $ni,
                'password' => $ni,
                'role' => 2,
                'is_active' => 1,
                'foto' => 'default.jpg',
                'created_at' => $created_at,
                'updated_at' => $created_at
            ]);

            $i++;
        }

        Siswa::insert($data);
        return redirect('/data_siswa')->with('pesan', '
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
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Siswa $siswa)
    {
        $data = [
            'no_induk' => $request->no_induk,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'is_active' => $request->is_active,
        ];

        Siswa::where('id', $siswa->id)
            ->update($data);
        return redirect('/data_siswa')->with('pesan', '
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
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Siswa $siswa)
    {
        Siswa::destroy($siswa->id);
        return redirect('/data_siswa')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "data di ubah!",
                    "success"
                )
            </script>
        ');
    }
}
