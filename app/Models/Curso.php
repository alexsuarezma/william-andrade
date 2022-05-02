<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    
    public function docente(){
        return $this->belongsTo('App\Models\User', 'docente_id');
    }

    // public function estudiantes(){
    //     return $this->belongsTo('App\Models\User', 'docente_id');
    // }

    public function estudiantes(){
        return $this->hasMany('App\Models\CursoHasEstudiante', 'curso_id');
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
