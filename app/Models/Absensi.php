<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    public $table = 'absensi';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $with = ['project', 'absensidetail'];

    // ganti route key name
    public function getRouteKeyName()
    {
        return 'kode';
    }

    // Relasikan ke project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi Ke Detail Absensi
    public function absensidetail()
    {
        return $this->hasMany(AbsensiDetail::class, 'kode', 'kode');
    }
}
