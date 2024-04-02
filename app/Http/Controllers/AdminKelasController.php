<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Project;
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
            'judul' => 'Presensi QR | Data Project',
            'plugin_css' => '
                <link href="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
                <link href="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
            ',
            'plugin_js' => '
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/jquery.dataTables.min.js"></script>
                <script src="'. asset('assets/template/presensi-abdul') .'/plugins/datatables/dataTables.bootstrap4.min.js"></script>
            ',
            'admin' => Admin::firstWhere('id', session('id')),
            'data_project' => Project::all()
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
            'judul' => 'Presensi QR | Tambah Project',
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
        $projects = $request->nama;
        $inserted_projects = Project::all()->pluck('nama')->toArray();

        $data = [];
        foreach ($projects as $project) {
            if (in_array(strtolower($project), array_map('strtolower', $inserted_projects))) {
                return redirect('/data_project')->with('pesan', '
                    <script>
                        Swal.fire(
                            "Error!",
                            "data sudah ada! ('.$project.')",
                            "error"
                        )
                    </script>
                ');
            } else {
                array_push($data, [
                    'nama' => $project
                ]);
            }
        }

        Project::insert($data);
        return redirect('/data_project')->with('pesan', '
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        Project::where('id', $project->id)
            ->update(['nama' => $request->nama]);

        return redirect('/data_project')->with('pesan', '
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        Project::destroy($project->id);

        return redirect('/data_project')->with('pesan', '
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
