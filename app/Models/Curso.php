<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    // public function estudiantes(){
    //     return $this->belongsTo('App\Models\User', 'docente_id');
    // }

    public function materias(){
        return $this->hasMany('App\Models\Materia', 'curso_id');
    }
}
