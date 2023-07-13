<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    public $table = 'siswa';
    protected $guarded = ['id'];
    protected $with = ['kelas'];

    // Relasikan ke Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
