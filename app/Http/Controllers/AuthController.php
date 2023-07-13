<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'judul' => 'Presensi QR BY Abduloh Malela | LOGIN FORM',
            'admin' => Admin::first()
        ]);
    }
    public function install(Request $request)
    {
        $data = [
            'nama'=> $request->nama,
            'username' => $request->username,
            'password' => $request->password,
            'role' => 1,
            'is_active' => 1,
            'foto' => 'default.jpg',
        ];

        Admin::create($data);
        return redirect('/')->with('pesan', '
            <script>
                Swal.fire(
                    "Success!",
                    "akun admin berhasil dibuat!",
                    "success"
                )
            </script>
        ');
    }
    public function login(Request $request)
    {
        // Cek siapa Yang Login
        $user = Admin::firstWhere('username', $request->username);
        if ($user !== null) {

            if ($user->password !== $request->password) {
                return redirect('/')->with('pesan', '
                    <script>
                        Swal.fire(
                            "Error!",
                            "Password salah!",
                            "error"
                        )
                    </script>
                ');
            }
            
            session()->put('role', 1);
            session()->put('id', $user->id);

            return redirect('/admin/dashboard')->with('pesan', '
                <script>
                    Swal.fire(
                        "Success!",
                        "berhasil login!",
                        "success"
                    )
                </script>
            ');
        }

        $user = Siswa::firstWhere('username', $request->username);
        if ($user !== null) {

            if ($user->password !== $request->password) {
                return redirect('/')->with('pesan', '
                    <script>
                        Swal.fire(
                            "Error!",
                            "Password salah!",
                            "error"
                        )
                    </script>
                ');
            }

            session()->put('role', 1);
            session()->put('id', $user->id);

            return redirect('/siswa_dashboard')->with('pesan', '
                <script>
                    Swal.fire(
                        "Success!",
                        "berhasil login!",
                        "success"
                    )
                </script>
            ');
        }

        return redirect('/')->with('pesan', '
            <script>
                Swal.fire(
                    "Error!",
                    "Akun tidak ditemukan!",
                    "error"
                )
            </script>
        ');
    }
    public function logout(Request $request)
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $request->session()->forget('role');
        $request->session()->forget('id');

        return redirect('/');
    }
}
