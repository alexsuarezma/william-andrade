<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Curso;
use App\Models\CursoHasMateria;
use App\Models\User;

class CursoController extends Controller
{
    public function create(Request $request){

        $validatedData = $request->validate([
            'nombre'  => 'required|string|max:100',
            'descripcion' => 'required|string|max:150',
            'jornada' => 'required|string|max:100',
            'nivel' => 'required|string|max:100',
            'grupo' => 'required|string|max:100',
            'periodo' => 'required|string|max:100'
        ]);

        try {

            DB::beginTransaction();

            $curso = new Curso();

            $curso->nombre = $request->input('nombre'); 
            $curso->descripcion = $request->input('descripcion');
            $curso->jornada = $request->input('jornada'); 
            $curso->nivel = $request->input('nivel'); 
            $curso->grupo = $request->input('grupo'); 
            $curso->periodo = $request->input('periodo'); 

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
            'jornada' => 'required|string|max:100',
            'nivel' => 'required|string|max:100',
            'grupo' => 'required|string|max:100',
            'periodo' => 'required|string|max:100'
        ]);

        try {

            DB::beginTransaction();

            $curso = Curso::where('id', $request->input('id'))->first();

            if(!$curso){
                throw new \Exception("El curso al que intenta acceder no se encuentra", 1);
            }

            $curso->nombre = $request->input('nombre'); 
            $curso->descripcion = $request->input('descripcion');
            $curso->jornada = $request->input('jornada'); 
            $curso->nivel = $request->input('nivel'); 
            $curso->grupo = $request->input('grupo'); 
            $curso->periodo = $request->input('periodo'); 
            
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

    // views
    
    public function index(){
        $cursos = Curso::orderBy('created_at','desc')->paginate(10);
        return view('curso.index',[
            'cursos' => $cursos
        ]);
    }

    public function infoView($id){
        $curso = Curso::find($id);

        return view('curso.info', [
            'curso' => $curso
        ]);
    }

    public function updateView($id){
        $curso = Curso::find($id);
        
        return view('curso.actualizar', [
            'curso' => $curso
        ]);
    }

    public function register(){
        return view('curso.create');
    }

}
