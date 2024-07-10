<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KaryawanSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Karyawan::factory(20)->create();
    }
}
