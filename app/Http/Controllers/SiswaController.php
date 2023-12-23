<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absensi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $absensi_all = Absensi::where('tgl', date('m'))->get();
        return view('siswa.index', [
            'judul' => 'Presensi QR | Dashboard Karyawan',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                
            ',
            'karyawan' => Karyawan::firstWhere('id', session('id')),
            'presensi_list' => $absensi_all,
        ]);
    }
    public function profile()
    {
        return view('siswa.profile', [
            'judul' => 'Presensi QR | Profile Karyawan',
            'plugin_css' => '
                
            ',
            'plugin_js' => '
                
            ',
            'karyawan' => Karyawan::firstWhere('id', session('id')),
        ]);
    }
    public function edit(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir' => $request->tgl_lahir,
            'tempat_lahir' => $request->tempat_lahir,
        ];

        if ($request->file('foto')) {
            if ($request->foto_lama) {
                if ($request->foto_lama != 'default.jpg') {
                    Storage::delete('public/assets/user/' . $request->foto_lama);
                }
            }
            $data['foto'] = str_replace('public/assets/user/', '', $request->file('foto')->store('assets/user'));
        }

        Karyawan::where('id', session('id'))
            ->update($data);

        return redirect('/siswa_profile')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "data di ubah!",
                    "success"
                )
            </script>
        ');
    }
    public function password(Request $request, Karyawan $karyawan)
    {
        if ($request->password != $karyawan->password) {
            return redirect('siswa_profile')->with('pesan', '
                <script>
                    Swal.fire(
                        "Error!",
                        "current password salah!",
                        "error"
                    )
                </script>
            ');
        }

        Karyawan::where('id', $karyawan->id)
            ->update(['password' => $request->password2]);

        return redirect('siswa_profile')->with('pesan', '
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
