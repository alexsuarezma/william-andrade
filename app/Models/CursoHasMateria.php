<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoHasMateria extends Model
{
    use HasFactory;

    protected $table = 'cursos_has_materias';
    
    public function materia(){
        return $this->belongsTo('App\Models\Materia', 'materia_id');
    }

    public function curso(){
        return $this->belongsTo('App\Models\Curso', 'curso_id');
    }
}
