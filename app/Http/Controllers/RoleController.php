<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{

    public function create(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|distinct',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([ 'name' => $request->input('name') ]);

            $role->permissions()->sync($request->permissions);

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información creada satisfactoriamente <a href='/admin/role/update/{$role->id}'>Ir al Rol Asociado</a>"); 
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|distinct',
        ]);

        try {
            DB::beginTransaction();
            
            $role = Role::where('id', $request->input('id'))->first();
            
            if(!$role){
                throw new exception('No se ha encontrado el rol seleccionado.');
            }
            
            $role->name = $request->input('name');
            $role->update();

            $role->permissions()->sync($request->permissions);

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente <a href='/admin/role/update/{$role->id}'>Ir al Rol Asociado</a>"); 
    }

    public function delete(Request $request){
        $validatedData = $request->validate([
            'role' => 'required|numeric',
            // 'newRole' => 'required|numeric|max:30',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::where('id', $request->input('role'))->first();
            if(!$role){
                throw new exception('No se ha encontrado el rol seleccionado.');
            }
            
            $users = User::role($role)->get();
            $permissions = Permission::role($role)->get();
            
            if(!empty($request->input('newRole'))){
                $newRole = Role::where('id', $request->input('newRole'))->first();
                foreach($users as $user){
                    $user->assignRole($newRole);
                    $user->removeRole($role);
                    // revokePermissionTo
                }
            }else{
                foreach($users as $user){
                    $user->removeRole($role);
                    // revokePermissionTo
                }
            }
            
            /*
                Revocar los permisos que el rol tenia asignado
            */
            foreach($permissions as $permission){
                $role->revokePermissionTo($permission->id);
            }
            
            $role->delete();

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->route('role.index')->with('success', "Se elimino el elemento seleccionado"); 
    }

    public function revokeRoleToUser(Request $request){
        $validatedData = $request->validate([
            'password' => 'required|string|password',
            'roleid' => 'required|numeric',
            'users' => 'required|array|min:1',
            'users.*' => 'required|numeric|distinct',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::where('id', $request->input('roleid'))->first();
            if(!$role){
                throw new exception('No se ha encontrado el rol seleccionado.');
            }
            
            for($i=0;$i<count($request->input('users'));$i++){
                $user = User::where('id', $request->input('users')[$i])->first();
                if(!$user){
                    throw new exception("Usuario con id [{$request->input('users')[$i]}] no existe.");
                }   

                $user->removeRole($role);
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

        return redirect()->back()->with('success', "Se elimino el rol a los usuarios seleccionados."); 
    }

    public function assignRoleToUser(Request $request){
        $validatedData = $request->validate([
            'role' => 'required|numeric',
            'users' => 'required|array|min:1',
            'users.*' => 'required|numeric|distinct',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::where('id', $request->input('role'))->first();
            if(!$role){
                throw new exception('No se ha encontrado el rol seleccionado.');
            }
            
            for($i=0;$i<count($request->input('users'));$i++){
                $user = User::where('id', $request->input('users')[$i])->first();
                if(!$user){
                    throw new exception("Usuario con id [{$request->input('users')[$i]}] no existe.");
                }   

                $user->assignRole($role);
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

        return redirect()->back()->with('success', "Se agrego el rol a los usuarios seleccionados."); 
    }

    /*  
        VIEWS 
        CONTROLLERS
    */
    public function index(){
        return view('admin.role.index');
    }

    public function createView(){
        $permissions = Permission::all();
        
        return view('admin.role.register',[
            'permissions' => $permissions,
            'rolePermissions' => null,
        ]);
    }
    
    public function updateView($id){
        $role = Role::where('id', $id)->first();
        $permissions = Permission::all();
        $rolePermissions = Permission::select('id','name')
                                ->join('role_has_permissions', 'role_has_permissions.permission_id', '=','permissions.id')
                                ->where('role_id', $id)
                                ->get();
                            
        $users = User::role($role)->get(); 
        
        return view('admin.role.register', [
            'rolePermissions' => $rolePermissions,
            'role' => $role,
            'permissions' => $permissions,
            'users' => $users,
        ]);
    }
}
