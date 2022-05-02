<section class="content">

    <!-- Default box -->
    <div class="row">
        <div class="col-md-10">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" wire:model="search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <!-- select -->
            <div class="form-group">
                <!-- <label>Custom Select</label> -->
                <select class="custom-select" wire:change="changeFilter({{ $status === 1 ? 0 : 1}})">
                    <option {{ $status === 1 ? 'Selected' : ''}} >Activada</option>
                    <option {{ $status === 1 ? '' : 'Selected'}} >Desactivada</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card">
        <x-toast-message></x-toast-message>
        <div class="card-header">
            <h3 class="card-title">Usuarios</h3>

            <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
            </div>
        </div>
        <div class="card-body p-0">
            @if(count($usersSelected) > 0 && (\Auth::user()->can('usuario.eliminar') | \Auth::user()->can('usuario.editar.avanzado')))
                <div class="d-flex">
                    @can('usuario.desactivar.activar')
                        <!-- @click="isOpen = !isOpen" -->
                        <div class="pl-3 pt-2 pb-2">
                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-desactive-active-user">
                                @if($status == 1)
                                <i class="fas fa-users-slash" style="font-size:20px;"></i>
                                @else              
                                <i class="fas fa-check-square" style="font-size:20px;"></i>
                                @endif
                                <!-- {{ $status == 1 ? 'Desactivar' : 'Activar'}} cuenta -->
                            </button>
                        </div>
                    @endcan
                    @can('usuario.editar.avanzado')
                        <div class="pl-3 pt-2 pb-2">
                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-change-password-user">
                                <i class="fas fa-key" style="font-size:20px;"></i>
                            </button>
                        </div>
                    @endcan
                </div>
            @endif
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            <input id="checkMain" type="checkbox" class="" wire:click="$emit('checkOrUncheckAll')">
                        </th>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Nombres
                        </th>
                        <th style="width: 30%">
                            <!-- Team Members -->
                        </th>
                        <th>
                            Email
                        </th>
                        <th style="width: 8%" class="text-center">
                            Estado
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                </thead>
                <tbody class="usersTable">
                @forelse($users as $user)
                    <?php $roleName ='' ;?>
                    @forelse($user->roles as $ur)
                    <?php $roleName.= $ur->name;?>
                    @if(!$loop->last)
                        <?php $roleName.= ' | ';?>
                    @endif
                    @empty
                    <?php $roleName.= 'Sin rol asignado.';?>
                    @endforelse
                    <tr>
                        <td>
                            <label class="">
                                <input id="{{ $user->id }}" type="checkbox" class="" wire:click="addUserInArray({{ $user->id }}, {{ $user->active == 1 ? 0 : 1 }}, '{{ $user->name }}', '{{ $user->email }}', '{{$roleName}}', '{{$user->profile_photo_path ? $user->profile_photo_path : $user->profile_photo_url}}')">
                            </label>
                        </td>
                        <td>
                            #{{$user->id}}
                        </td>
                        <td>
                            <div class="d-flex justify-content-around align-items-center">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                <img alt="Avatar" class="table-avatar" src="{{$user->profile_photo_url}}">
                                </li>
                            </ul>
                            <div class="">
                                <a>
                                {{$user->name.' '.$user->lastname}}
                                </a>
                                <br/>
                                <small>
                                    Created {{$user->created_at}}
                                </small>
                            </div>
                            </div>
                        </td>
                        <td>
                        {{$roleName}}
                        </td>
                        <td class="project_progress">
                            {{$user->email}}
                        </td>
                        <td class="project-state">
                            <span class="badge badge-{{ $user->active == 1 ? 'success' : 'danger' }}">{{$user->active == 1 ? 'Activo': 'Desactivado' }}</span>
                        </td>
                        @can('usuario.editar.avanzado')
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('user.update', ['id' => $user->id] ) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Editar
                                </a>
                            </td>
                        @endcan
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        {{$users->links()}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <script>
        Livewire.on('removeUserInArray', id => {
            if (document.getElementById(id).checked){
            document.getElementById(id).checked = false
            }
        })

        Livewire.on('checkOrUncheckAll', () => {
        let checkboxs = document.querySelectorAll(".usersTable input[type=checkbox]")
        
        checkboxs.forEach((element) => {
            if(!element.checked && document.getElementById('checkMain').checked){
                element.click()
            }else if(element.checked && !document.getElementById('checkMain').checked){
                element.click()
            }
        });
        })
    </script>  

    <!-- <div id="myModal" class="modal-dialog modal-dialog-centered">
    ...
    </div> -->
    @can('usuario.desactivar.activar')
        <div class="modal fade" id="modal-desactive-active-user" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">{{ $status == 1 ? 'Desactivar' : 'Activar'}} Cuenta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <form action="{{route('user.desactive.account')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas {{ $status == 1 ? 'desactivar' : 'activar'}} las cuentas seleccionadas? Una vez que {{ $status == 1 ? 'desactive' : 'active'}} la cuenta, se {{ $status == 1 ? 'negara' : 'permitira'}}  el acceso del usuario a la plataforma. Ingrese su contraseña para confirmar que desea {{ $status == 1 ? 'desactivar' : 'activar'}} la cuenta.</p>
                        <div class="card-body table-responsive p-0" style="height: 200px;">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    @forelse($usersSelected as $userSelected)
                                        <tr>
                                            <td>{{$userSelected['name']}}</td>
                                            <input type="hidden" name="id[]" value="{{$userSelected['id']}}">
                                            <input type="hidden" name="active[]" value="{{$userSelected['active']}}">
                                            <td>{{$userSelected['email']}}</td>
                                            <td>{{$userSelected['role']}}</td>
                                            <!-- <td>
                                                <div class="btn btn-tool" wire:click="removeUserInArray( {{ $userSelected['id'] }} )">
                                                    <i class="fas fa-minus" style="font-size:20px;"></i>
                                                </div>
                                            </td> -->
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Tu contraseña, para confirmar" required>
                    </div>
                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">{{ $status == 1 ? 'Desactivar' : 'Activar'}}</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endcan
    @can('usuario.eliminar')
        <div class="modal fade" id="modal-change-password-user" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Cambiar contraseñas en cuentas seleccionadas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <form action="{{route('user.passwords.update')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas cambiar la contraseña a las cuentas seleccionadas?. </p>
                        <div class="card-body table-responsive p-0" style="height: 200px;">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    @forelse($usersSelected as $userSelected)
                                        <tr>
                                            <td>{{$userSelected['name']}}</td>
                                            <input type="hidden" name="id[]" value="{{$userSelected['id']}}">
                                            <input type="hidden" name="active[]" value="{{$userSelected['active']}}">
                                            <td>{{$userSelected['email']}}</td>
                                            <td>{{$userSelected['role']}}</td>
                                            <!-- <td>
                                                <div class="btn btn-tool" wire:click="removeUserInArray( {{ $userSelected['id'] }} )">
                                                    <i class="fas fa-minus" style="font-size:20px;"></i>
                                                </div>
                                            </td> -->
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <input type="password" name="passwordUsers" class="form-control" placeholder="Nueva Contraseña" required>
                    </div>
                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endcan
</section>