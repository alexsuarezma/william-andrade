<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use App\Models\User;

class UserController extends Controller
{
    public function create(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'username' => 'required|string|max:60',
            'email' => 'required|string|max:100|email|unique:users,email,',
            // 'password' => 'required|max:255|min:8|confirmed',
            // 'password_confirmation'  => 'required|max:255|same:password'
        ]);

        try {
            DB::beginTransaction();

            $user = new User();

            $user->name = $request->input('name');
            $user->lastname = $request->input('lastname'); 
            $user->email = $request->input('email'); 
            $user->username = $request->input('username'); 
            $user->admin = $request->input('admin') == 1 ? true : false; 
            $password = Hash::make(strtolower($request->input('username')).'123');
        
            $user->password = $password;

            $user->save();

            if(!($request->input('permissions') === null)){
                for($i=0;$i<count($request->input('permissions'));$i++){
                    $user->givePermissionTo($request->input('permissions')[$i]);
                }
            }

            for($i=0;$i<count($request->input('roles'));$i++){
                $user->assignRole($request->input('roles')[$i]);
            }

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
            'id' => 'required',
            'name' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'username' => 'required|string|max:60',
            'email'  => 'required|string|email|max:255|unique:users,email,'.$request->input('id'),
        ]);

        try {
            DB::beginTransaction();

            $user = User::where('id', $request->input('id'))->first();

            if(!$user){
                throw new \Exception("El usuario al que intenta acceder no se encuentra", 1);
            }

            $user->name = $request->input('name');
            $user->lastname = $request->input('lastname'); 
            $user->username = $request->input('username'); 
            $user->email = $request->input('email'); 
            $user->admin = $request->input('admin') == 1 ? true : false; 

            $user->update();

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente"); 
    }

    public function changePassword(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required',
            'password' => 'required|max:255|min:8|confirmed',
            'password_confirmation'  => 'required|max:255|same:password'
        ]);
        
        try {
            DB::beginTransaction();
            
            $user = User::where('id', $request->input('id'))->first();

            if(!$user){
                throw new \Exception("El usuario al que intenta acceder no se encuentra", 1);
            }

            $password = Hash::make($request->input('password'));
            
            $user->password = $password;

            $user->update();

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Contraseña actualizada correctamente"); 
    }

    public function desactiveAccount(Request $request){
        $validatedData = $request->validate([
            'password' => 'required|string|password',
            'id' => 'required|array|min:1',
            'id.*' => 'required|numeric|distinct',
            'active' => 'required|array|min:1',
            'active.*' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            for($i=0;$i<count($request->input('id'));$i++){
               $user = User::where('id', $request->input('id')[$i])->first();
               
               if(!$user){
                    throw new Exception("El usuario al que intenta acceder no existe. ID = {$request->input('id')[$i]}", 1);
               }
               $user->active = $request->input('active')[$i];

               $user->update();  
               
               if($user->active == 0){
                   if (config('session.driver') !== 'database') {
                       return;
                    }
                    
                    DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $request->input('id')[$i])
                    ->delete();
                }
            }
            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente");
    }

    public function updatePasswordsUsers(Request $request){
        $validatedData = $request->validate([
            'passwordUsers' => 'required|string',
            'id' => 'required|array|min:1',
            'id.*' => 'required|numeric|distinct',
        ]);

        try {
            DB::beginTransaction();

            for($i=0;$i<count($request->input('id'));$i++){
               $user = User::where('id', $request->input('id')[$i])->first();

               if(!$user){
                    throw new Exception("El usuario al que intenta acceder no existe. ID = {$request->input('id')[$i]}", 1);
                }

               $password = Hash::make($request->input('passwordUsers'));
               $user->password = $password;

               $user->update();  
            }
            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente");
    }

    public function updateInformationUser(Request $request){
        
        $validatedData = $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|string|max:25',
            'lastname' => 'required|string|max:25',
            'username' => 'required|string|max:30',
            'email' => 'required|string|max:100|email|unique:users,email,'.$request->input('id'),
            'roles' => 'required|array|min:1',
            'roles.*' => 'required|numeric|distinct',
            'permissions.*' => 'numeric',
        ]);

        try {

            
            DB::beginTransaction();

            $user = User::where('id',$request->input('id'))->first();
            
            if(!$user){
                throw new Exception("El usuario al que intenta acceder no existe.", 1);
            }
            
            $lastEmail = $user->email;
            
            $user->name = $request->input('name'); 
            $user->lastname = $request->input('lastname'); 
            $user->username = $request->input('username'); 
            $user->email = $request->input('email'); 
        
            $user->update();
        
            // $this->verifyEmailForUpdateInformation($lastEmail, $user);

            $permissions =  DB::table('permissions')
                                ->join('model_has_permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
                                ->select('permissions.id')
                                ->where('model_has_permissions.model_id', $user->id) ->get();

            foreach($permissions as $permission){
                $user->revokePermissionTo($permission->id);
            }

            if(!($request->input('permissions') === null)){
                for($i=0;$i<count($request->input('permissions'));$i++){
                    $user->givePermissionTo($request->input('permissions')[$i]);
                }
            }
            
            $roles = DB::table('roles')->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->select('roles.id')->where('model_has_roles.model_id', $user->id) ->get();
            
            foreach($roles as $role){
                $user->removeRole($role->id);
            }

            for($i=0;$i<count($request->input('roles'));$i++){
                $user->assignRole($request->input('roles')[$i]);
            }

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente"); 
    }

    public function updateInformationProfile(Request $request){
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
            'username' => 'required|string|max:30',
            'email' => 'required|string|max:100|email|unique:users,email,'.\Auth::user()->id,
            'lastname' => 'required|string|max:30',
        ]);

        try {
            $user = \Auth::user();
            
            $lastEmail = $user->email;

            $user->name = $request->input('name'); 
            $user->lastname = $request->input('lastname'); 
            $user->username = $request->input('username'); 
            $user->email = $request->input('email'); 
            
            $user->update();
            
        } catch(Illuminate\Database\QueryException $error){
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente");
    }

    public function updatePasswordUser(Request $request){
        
        $validatedData = $request->validate([
            // 'id' => ['exclude_if:password_verified,"true"','required', 'numeric'],
            'current_password' => 'required|max:255|password',
            'password' => 'required|max:255|min:8|confirmed',
            'password_confirmation'  => 'required|max:255|same:password'
        ]);

        try {
            
            DB::beginTransaction();
            
            $user = \Auth::user();
            
            if(!$user){
                throw new Exception("El usuario al que intenta acceder no existe.", 1);
            }
            
            $password = Hash::make($request->input('password'));
            $user->password = $password;
            
            if ( !($request->input('password_verified') === null) ){
                $user->password_verified = \Carbon\Carbon::now();
            }
            
            $user->update();

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente"); 
    }

    public function index(){
        $users = User::orderBy('created_at','desc')->paginate(10);
        return view('user.index', [
            'users' => $users
        ]);
    }

    public function updateView($id){
        $user = User::find($id);
        return view('user.actualizar', [
            'user' => $user
        ]);
    }

    public function updateInformationUserView($id){
        $user = User::where('id', $id)->with(['roles'])->first();
        $userPermissions = $user->getAllPermissions();
    
        $userRoles = DB::table('roles')
            ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('roles.*')
            ->where('model_has_roles.model_id', $id) 
            ->get();

        $rolesSelected = array();
        $idRoles = array();

        if(count($userRoles) > 0){
            foreach($userRoles as $role){
                array_push($rolesSelected,array('id' => $role->id, 'name' => $role->name));
                array_push($idRoles,$role->id);
            }
        }

        return view('auth.register',[
            'user' => $user,
            'roles' => Role::all(),
            'userPermissions' => $userPermissions,
            'rolesSelected' => $rolesSelected,
            'idRoles' => $idRoles,
        ]);
    }
}
