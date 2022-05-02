<?php

namespace App\Http\Livewire\Admin\Role;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ReAssign extends Component
{
    public $newRoleId;
    public $roleId;
    public $messagess;

    protected $listeners = ['selectNewRole','changeRoleId'];

    public function render()
    {
        return view('livewire.admin.role.re-assign',[
            'permissionNewRole' => Role::where('id', $this->newRoleId)->first(),
            'roles' => Role::where('id', '<>', $this->roleId)->get(),
        ]);
    }

    public function selectNewRole($id){
        try{
            $role = $this->validarRoleSeleccionado($id);
            if(!$role){
                throw new Exception($this->messagess, 1);
            }
            if($this->messagess != ''){
                throw new Exception($this->messagess, 1);
            }

            $this->newRoleId = $id;

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

    public function changeRoleId($id){
        $this->roleId = $id;
        return;
    }
}
