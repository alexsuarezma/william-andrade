<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaHasEstudiante extends Model
{
    use HasFactory;

    protected $table = 'materias_has_estudiantes';
    
    public function estudiante(){
        return $this->belongsTo('App\Models\User', 'estudiante_id');
    }

    public function materia(){
        return $this->belongsTo('App\Models\Materia', 'materia_id');
    }
}
