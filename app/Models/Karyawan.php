<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;
    
    public $table = 'karyawan';
    
    protected $guarded = ['id'];

    protected $with = ['project'];

    // Relasikan ke project
    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }
}
