<?php

namespace App\Http\Livewire\Admin\Role;

use Livewire\Component;

use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSelected extends Component
{
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search' => ['except'=>'']];

    public $search = '';
    public $usersSelected = array();
    public $users;
    public $role;

    protected $listeners = ['removeUserInArray'];

    public function render()
    {
        return view('livewire.admin.role.user-selected',
                    [
                        /*
                            Trae todos los usuarios que no tienen ese rol.
                        */
                        'usersFound' => User::where( function($query) {
                                                    $query->where('active', 1)->where('name', 'LIKE', "%{$this->search}%")->orWhere('email', 'LIKE', "%{$this->search}%");
                                                    // ->orWhere('lastname', 'LIKE', "%{$this->search}%");
                                                })->whereDoesntHave('roles', function ($query) {
                                                    $query->where('name', $this->role->name);
                                                })->paginate(10)
                    ]);
    }

    public function addUserInArray($id,$name,$email,$photo){
        $flag = $this->removeUserInArray($id);

        if(!$flag){
            array_push($this->usersSelected,
                            array(
                                    'id' => $id,
                                    'name' => $name,
                                    'email' => $email,
                                    'photo' => $photo,
                                )
                    );
        }

    }

    public function removeUserInArray($id){
        foreach($this->usersSelected as $index => $user){
            if($user['id'] == $id){
                unset($this->usersSelected[$index]);
                $this->emit('removeUserInArray', $id);
                return true;
            }
        }
        return false;
    }
}
