<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoHasEstudiante extends Model
{
    use HasFactory;

    protected $table = 'cursos_has_estudiantes';
    
    public function estudiante(){
        return $this->belongsTo('App\Models\User', 'estudiante_id');
    }

    public function curso(){
        return $this->belongsTo('App\Models\Curso', 'curso_id');
    }
}
