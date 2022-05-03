<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Materia;
use App\Models\Curso;
use App\Models\MateriaHasEstudiante;
use App\Models\User;

class MateriaController extends Controller
{
    public function create(Request $request){

        $validatedData = $request->validate([
            'nombre'  => 'required|string|max:100',
            'descripcion' => 'required|string|max:150',
            'curso_id' => 'required|numeric',
            'docente_id' => 'required|numeric',
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'required|date|after:fecha_apertura'
        ]);

        try {

            DB::beginTransaction();

            $materia = new Materia();

            $materia->nombre = $request->input('nombre'); 
            $materia->descripcion = $request->input('descripcion');
            $materia->link_clase = $request->input('link_clase'); 
            $materia->fecha_apertura = $request->input('fecha_apertura'); 
            $materia->fecha_cierre = $request->input('fecha_cierre'); 
            $materia->docente_id = $request->input('docente_id'); 
            $materia->curso_id = $request->input('curso_id'); 
            $materia->malla_id = $request->input('malla_id'); 
            
            $materia->save();

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información creada satisfactoriamente"); 
    }

    public function update(Request $request){

        $validatedData = $request->validate([
            'nombre'  => 'required|string|max:100',
            'descripcion' => 'required|string|max:150',
            'curso_id' => 'required|numeric',
            'docente_id' => 'required|numeric',
            'fecha_apertura' => 'required|date',
            'fecha_cierre' => 'required|date|after:fecha_apertura'
        ]);

        try {

            DB::beginTransaction();

            $materia = Materia::where('id', $request->input('id'))->first();

            if(!$materia){
                throw new \Exception("El materia al que intenta acceder no se encuentra", 1);
            }

            $materia->nombre = $request->input('nombre'); 
            $materia->descripcion = $request->input('descripcion');
            $materia->link_clase = $request->input('link_clase'); 
            $materia->fecha_apertura = $request->input('fecha_apertura'); 
            $materia->fecha_cierre = $request->input('fecha_cierre'); 
            $materia->docente_id = $request->input('docente_id'); 
            $materia->curso_id = $request->input('curso_id'); 
            $materia->malla_id = $request->input('malla_id'); 

            $materia->update();

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información creada satisfactoriamente"); 
    }

    public function inscribirse(Request $request){

        $validatedData = $request->validate([
            'materia_id'  => 'required|numeric',
            // 'estudiante_id' => 'required|numeric'
        ]);

        try {

            DB::beginTransaction();

            $materia = Materia::where('id', $request->input('materia_id'))->first();

            if(!$materia){
                throw new \Exception("El materia al que intenta acceder no se encuentra", 1);
            }

            $materia_estudiante = MateriaHasEstudiante::where('materia_id', $request->input('materia_id'))->where('estudiante_id', \Auth::user()->id)->first();

            if($materia_estudiante){
                throw new \Exception("El estudiante ".\Auth::user()->name." ya se encuentra inscrito en la materia al que intenta acceder", 1);
            }

            $materia_has_estudiante = new MateriaHasEstudiante();

            $materia_has_estudiante->materia_id = $materia->id;
            $materia_has_estudiante->estudiante_id = \Auth::user()->id;

            $materia_has_estudiante->save();

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información creada satisfactoriamente"); 
    }
    
    public function desinscribirse(Request $request){

        $validatedData = $request->validate([
            'materia_id'  => 'required|numeric',
            // 'estudiante_id' => 'required|numeric'
        ]);

        try {

            DB::beginTransaction();

            $materia_has_estudiante = MateriaHasEstudiante::where('materia_id', $request->input('materia_id'))->where('estudiante_id', \Auth::user()->id)->first();

            if(!$materia_has_estudiante){
                throw new \Exception("El materia al que intenta acceder no se encuentra", 1);
            }

            $materia_has_estudiante->delete();

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información creada satisfactoriamente"); 
    }



    // views
    
    public function index(){
        $materias = Materia::orderBy('created_at','desc')->paginate(10);
        return view('materia.index');
    }

    public function infoView($id){
        $materia = Materia::find($id);
        
        $estudiante_existe = MateriaHasEstudiante::where('materia_id', $id)->where('estudiante_id', \Auth::user()->id)->first();

        return view('materia.info', [
            'materia' => $materia,
            'estudiante_existe' => $estudiante_existe
        ]);
    }

    public function updateView($id){
        $materia = Materia::find($id);
        
        $docentes = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Docente');
        })->get();

        $cursos = Curso::where('estado', 1)->get();
        
        return view('materia.actualizar', [
            'materia' => $materia,
            'docentes' => $docentes,
            'cursos' => $cursos
        ]);
    }

    public function register(){
        $docentes = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Docente');
        })->get();
        
        $cursos = Curso::where('estado', 1)->get();

        return view('materia.create', [
            'docentes' => $docentes,
            'cursos' => $cursos
        ]);
    }

}
