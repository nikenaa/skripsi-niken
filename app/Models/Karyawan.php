<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    
    public $table = 'karyawan';
    
    protected $guarded = ['id'];

    protected $with = ['project'];

    // Relasikan ke project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
