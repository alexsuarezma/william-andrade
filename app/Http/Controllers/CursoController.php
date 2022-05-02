<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Curso;
use App\Models\CursoHasEstudiante;
use App\Models\User;

class CursoController extends Controller
{
    public function create(Request $request){

        $validatedData = $request->validate([
            'nombre'  => 'required|string|max:100',
            'descripcion' => 'required|string|max:150',
            'docente_id' => 'required|numeric',
            'fecha_apertura' => 'required',
            'fecha_cierre' => 'required'
        ]);

        try {

            DB::beginTransaction();

            $curso = new Curso();

            $curso->nombre = $request->input('nombre'); 
            $curso->descripcion = $request->input('descripcion');
            $curso->link_clase = $request->input('link_clase'); 
            $curso->fecha_apertura = $request->input('fecha_apertura'); 
            $curso->fecha_cierre = $request->input('fecha_cierre'); 
            $curso->docente_id = $request->input('docente_id'); 

            $curso->save();

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
            'docente_id' => 'required|numeric',
            'fecha_apertura' => 'required',
            'fecha_cierre' => 'required'
        ]);

        try {

            DB::beginTransaction();

            $curso = Curso::where('id', $request->input('id'))->first();

            if(!$curso){
                throw new \Exception("El curso al que intenta acceder no se encuentra", 1);
            }

            $curso->nombre = $request->input('nombre'); 
            $curso->descripcion = $request->input('descripcion');
            $curso->link_clase = $request->input('link_clase'); 
            $curso->fecha_apertura = $request->input('fecha_apertura'); 
            $curso->fecha_cierre = $request->input('fecha_cierre'); 
            $curso->docente_id = $request->input('docente_id'); 
            
            $curso->update();

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
            'curso_id'  => 'required|numeric',
            // 'estudiante_id' => 'required|numeric'
        ]);

        try {

            DB::beginTransaction();

            $curso = Curso::where('id', $request->input('curso_id'))->first();

            if(!$curso){
                throw new \Exception("El curso al que intenta acceder no se encuentra", 1);
            }

            $curso_estudiante = CursoHasEstudiante::where('curso_id', $request->input('curso_id'))->where('estudiante_id', \Auth::user()->id)->first();

            if($curso_estudiante){
                throw new \Exception("El estudiante ".\Auth::user()->name." ya se encuentra inscrito en el curso al que intenta acceder", 1);
            }

            $curso_has_estudiante = new CursoHasEstudiante();

            $curso_has_estudiante->curso_id = $curso->id;
            $curso_has_estudiante->estudiante_id = \Auth::user()->id;

            $curso_has_estudiante->save();

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
            'curso_id'  => 'required|numeric',
            // 'estudiante_id' => 'required|numeric'
        ]);

        try {

            DB::beginTransaction();

            $curso_has_estudiante = CursoHasEstudiante::where('curso_id', $request->input('curso_id'))->where('estudiante_id', \Auth::user()->id)->first();

            if(!$curso_has_estudiante){
                throw new \Exception("El curso al que intenta acceder no se encuentra", 1);
            }

            $curso_has_estudiante->delete();

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
        $cursos = Curso::orderBy('created_at','desc')->paginate(10);
        return view('curso.index');
    }

    public function infoView($id){
        $curso = Curso::find($id);
        
        $estudiante_existe = CursoHasEstudiante::where('curso_id', $id)->where('estudiante_id', \Auth::user()->id)->first();

        return view('curso.info', [
            'curso' => $curso,
            'estudiante_existe' => $estudiante_existe
        ]);
    }

    public function updateView($id){
        $curso = Curso::find($id);
        
        $docentes = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Docente');
        })->get();


        return view('curso.actualizar', [
            'curso' => $curso,
            'docentes' => $docentes
        ]);
    }

    public function register(){
        $docentes = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Docente');
        })->get();

        return view('curso.create', [
            'docentes' => $docentes
        ]);
    }

}
