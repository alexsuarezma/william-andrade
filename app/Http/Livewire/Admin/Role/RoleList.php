<?php

namespace App\Http\Livewire\Admin\Role;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleList extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search' => ['except'=>'']];

    public $search = '';
    public $messagess = '';
    public $roleSelected;
    public $roleId;

    public function render()
    {
        return view('livewire.admin.role.role-list',
                        [
                            'roles' => Role::where('name', 'LIKE', "%{$this->search}%")->paginate(10),
                            /*
                                Traer todos los usuarios que tienen asignado ese rol.
                            */
                            'userRoles' => User::select('name','email','profile_photo_path')
                                                ->join('model_has_roles', 'users.id' , '=', 'model_has_roles.model_id')
                                                ->where('role_id', $this->roleId)
                                                ->get(),
                            'permissions' => Permission::select('name')
                                                        ->join('role_has_permissions', 'role_has_permissions.permission_id', '=','permissions.id')
                                                        ->where('role_id', $this->roleId)
                                                        ->get(),
                        ]);
    }

    public function __construct(){
        $this->roleSelected = new Role();
    }

    public function selectRole($id){
        try{
            
            $role = $this->validarRoleSeleccionado($id);
            if(!$role){
                throw new Exception($this->messagess, 1);
            }
            if($this->messagess != ''){
                throw new Exception($this->messagess, 1);
            }

            $this->roleId = $id;
            $this->roleSelected = $role;
            $this->emit('changeRoleId', $id);
            
        } catch(Illuminate\Database\QueryException $error){
            $this->messagess = "Oh, parece que hubo un error: {$error->getMessage()}";
            return;
        }
        catch(\Exception $error){
            $this->messagess = "Oh, parece que hubo un error: {$error->getMessage()}";
            return;
        }
    }

    public function validarRoleSeleccionado($id){
        $role;
        try{
            
            $role = Role::where('id', $id)->first();

            if(!$role){
                throw new exception('No se ha encontrado el rol seleccionado.');
            }
            return $role;
        } catch(Illuminate\Database\QueryException $error){
            $this->messagess = $error->getMessage();
            return $role;
        }
        catch(\Exception $error){
            $this->messagess = $error->getMessage();
            return $role;
        }
    }
}
