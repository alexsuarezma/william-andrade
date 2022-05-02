<?php

namespace App\Http\Livewire\Admin\Role;

use Livewire\Component;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AgregateRol extends Component
{

    public $roles;
    public $idRoles = array();
    public $remainingPermissions;
    public $rolesSelected = array();
    public $userPermissions;

    public function render()
    {
        $this->remainingPermissions = Permission::whereExists(function ($query){
                $query->select(DB::raw(1))->from('role_has_permissions')->whereNotIn('role_has_permissions.role_id',$this->idRoles);
            })->get();

        return view('livewire.admin.role.agregate-rol');
    }

    public function addRoleInArray($id, $name){
        $flag = $this->removeRoleInArray($id, true);
        
        if(!$flag){
            array_push($this->rolesSelected,array('id' => $id, 'name' => $name));
            array_push($this->idRoles,$id);
        }
    }

    public function removeRoleInArray($id, $remove = true){
        foreach($this->rolesSelected as $index => $role){
            if($role['id'] == $id){
                if($remove){
                    unset($this->rolesSelected[$index]);
                    unset($this->idRoles[$index]);
                }
                return true;
            }
        }
        return false;
    }

}
