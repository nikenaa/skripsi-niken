<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.dashboard', [
            'judul' => 'Presensi QR BY Abduloh Malela | Dashboard Admin',
            'plugin_css' => '',
            'plugin_js' => '',
            'siswa' => Siswa::all(),
            'kelas' => Kelas::all(),
            'absensi' => Absensi::all(),
            'data_admin' => Admin::all(),
            'admin' => Admin::firstWhere('id', session('id'))
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index', [
            'judul' => 'Presensi QR BY Abduloh Malela | Data Admin',
            'plugin_css' => '
                <link href="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
                <link href="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            ',
            'plugin_js' => '
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/jquery.dataTables.min.js"></script>
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/dataTables.bootstrap4.min.js"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'data_admin' => Admin::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create', [
            'judul' => 'Presensi QR BY Abduloh Malela | Tambah Admin',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                
            ',
            'admin' => Admin::firstWhere('id', session('id'))
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
        $admins = [];
        $created_at = now();
        $i = 0;
        $namas = $request->nama;
        foreach ($namas as $nama) {
            array_push($admins, [
                'nama' => $nama,
                'username' => $request->username[$i],
                'password' => $request->password[$i],
                'role' => 1,
                'is_active' => 1,
                'foto' => 'default.jpg',
                'created_at' => $created_at,
                'updated_at' => $created_at
            ]);

            $i++;
        }

        Admin::insert($admins);

        return redirect('/admin')->with('pesan', '
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
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view('admin.profile', [
            'judul' => 'Presensi QR BY Abduloh Malela | Profile Admin',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                
            ',
            'admin' => Admin::firstWhere('id', session('id'))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        if ($request->edit == 'admins') {
            $data = [
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $request->password,
                'is_active' => $request->is_active,
            ];
            $redirect = '/admin';
        }

        if ($request->edit == 'admin') {
            // cek apakah ada gambar yang di upload
            if ($request->file('foto')) {
                if ($request->foto_lama) {
                    if ($request->foto_lama != 'default.jpg') {
                        Storage::delete('assets/user/' . $request->foto_lama);
                    }
                }
                $data['foto'] = str_replace('assets/user/', '', $request->file('foto')->store('assets/user'));
            }
            $data['nama'] = $request->nama;
            $redirect = '/admin/' . $admin->id;
        }
        
        Admin::where('id', $admin->id)
            ->update($data);

        return redirect($redirect)->with('pesan', '
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
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        Admin::destroy($admin->id);
        return redirect('/admin')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "data di hapus!",
                    "success"
                )
            </script>
        ');
    }

    public function password(Request $request, Admin $admin)
    {
        if ($request->password != $admin->password) {
            return redirect('/admin/' . $admin->id)->with('pesan', '
                <script>
                    Swal.fire(
                        "Error!",
                        "current password salah!",
                        "error"
                    )
                </script>
            ');
        }

        Admin::where('id', $admin->id)
            ->update(['password' => $request->password2]);

        return redirect('/admin/' . $admin->id)->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "password di edit!",
                    "success"
                )
            </script>
        ');
    }
}
