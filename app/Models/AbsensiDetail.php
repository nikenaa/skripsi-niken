<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiDetail extends Model
{
    use HasFactory;
    public $table = 'absensi_detail';
    protected $guarded = ['id'];
    public $with = ['karyawan'];

    // Relasikan ke Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class)->withTrashed();
    }
}
