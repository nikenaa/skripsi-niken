<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Project;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class AdminSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_karyawan()
    {
        return view('admin.siswa.index', [
            'judul' => 'Presensi QR | Data Karyawan',
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
            'data_karyawan' => Karyawan::all(),
            'project' => Project::all()
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
            'judul' => 'Presensi QR | Tambah Karyawan',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'data_karyawan' => Karyawan::all(),
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
        $no_induk = $request->no_induk;
        $data = [];
        $i = 0;
        $created_at = now();
        foreach ($no_induk as $ni) {
            array_push($data, [
                'no_induk'=> $ni,
                'nama' => $request->nama[$i],
                'project_id' => $request->project_id[$i],
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

        Karyawan::insert($data);
        return redirect('/data_karyawan')->with('pesan', '
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
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $data = [
            'no_induk' => $request->no_induk,
            'nama' => $request->nama,
            'project_id' => $request->project_id,
            'is_active' => $request->is_active,
        ];

        Karyawan::where('id', $karyawan->id)
            ->update($data);
        return redirect('/data_karyawan')->with('pesan', '
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
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan)
    {
        Karyawan::destroy($karyawan->id);
        return redirect('/data_karyawan')->with('pesan', '
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
