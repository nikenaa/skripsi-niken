<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiDetail extends Model
{
    use HasFactory;
    public $table = 'absensi_detail';
    protected $guarded = ['id'];
    public $with = ['siswa'];

    // Relasikan ke Karyawan
    public function siswa()
    {
        return $this->belongsTo(Karyawan::class);
    }

}