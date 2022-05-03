<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    
    public function docente(){
        return $this->belongsTo('App\Models\User', 'docente_id');
    }

    public function curso(){
        return $this->belongsTo('App\Models\Curso', 'curso_id');
    }

    // public function estudiantes(){
    //     return $this->belongsTo('App\Models\User', 'docente_id');
    // }

    public function estudiantes(){
        return $this->hasMany('App\Models\MateriaHasEstudiante', 'materia_id');
        // return $this->hasManyThrough(
        //     'App\Models\CursoHasEstudiante',
        //     'App\Models\User',
        //     'id',
        //     'estudiante_id',
        //     'id',
        //     'id'
        // );
    }
}
