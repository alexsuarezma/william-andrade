<div> 
    <div class="callout callout-info">
        <h5>Usuarios con este Rol</h5>
        <p>Los siguientes usuarios se veran afectados a nivel de permisos</p>
    </div>
    @if(count($usersSelected) > 0)
        <div class="pl-3 pt-2 pb-2">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-revoke-role-user">
                <i class="fas fa-minus" style="font-size:20px;"></i>
            </button>
        </div>
    @endif
    <div class="card-body table-responsive p-0" style="height: 200px;">
        <table class="table table-head-fixed text-nowrap"> 
            <table class="table table-striped projects">
                <tbody>
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
                                    <input id="remove_{{ $user->id }}" type="checkbox" class="" wire:click="addUserInArray({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{$user->profile_photo_path ? $user->profile_photo_path : $user->profile_photo_url}}')">
                                </label>
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
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{$roleName}}
                            </td>
                            <td class="project_progress">
                                {{$user->email}}
                            </td>
                        </tr>
                    @empty
                        <span>No existen usuarios con este rol.</span>
                    @endforelse
                </tbody>
            </table>
        </table>
    </div>
    <div class="d-flex align-items-center justify-content-center">
        <div class="pl-3 pt-2 pb-2">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-agregate-role-user">
                <i class="fas fa-users-slash" style="font-size:20px;"></i>
            </button>
        </div>
    </div>
    <div class="modal fade" id="modal-revoke-role-user" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Revocar rol</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{route('role.revoke.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="roleid" value ="{{$role->id}}">
                    <div class="modal-body">
                        <div class="callout callout-info">
                            <h5>Revocar este Rol</h5>
                            <p>¿Estás seguro de que deseas revocar el rol '<span class="font-bold">{{ucwords($role->name)}}</span>' en las cuentas seleccionadas? Una vez revocado, podrias limitar el acceso del usuario a la plataforma. </p>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 200px;">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    @forelse($usersSelected as $userSelected)
                                        <tr>
                                            <input type="hidden" name="users[]" value="{{$userSelected['id']}}">
                                            <td>{{$userSelected['name']}}</td>
                                            <td>{{$userSelected['email']}}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        Ingrese su contraseña para confirmar la operación.
                        <input type="password" name="password" class="form-control" placeholder="Tu contraseña, para confirmar">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Revocar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div wire:ignore.self class="modal fade" id="modal-agregate-role-user" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Añadir usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{route('role.assign.create')}}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="role" value ="{{$role->id}}">
                    <div class="modal-body">
                        <div class="callout callout-info">
                            <h5>Añadir usuario</h5>
                            <p>Puedes asignarle el rol '<span class="font-bold">{{ucwords($role->name)}}</span>' al usuario que selecciones.</p>
                        </div>
                        <p>Sugerencias</p>
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
                        <div class="card-body table-responsive p-0" style="padding-top:40px; height: 200px;">
                            <table class="table table-head-fixed text-nowrap">
                                <tbody>
                                    @forelse($usersFound as $userFound)
                                        <tr>
                                            <td>
                                                <label class="">
                                                    <input name="users[]" value="{{$userFound->id}}" type="checkbox">
                                                </label>
                                            </td>
                                            <td>{{$userFound->name}}</td>
                                            <td>{{$userFound->email}}</td>
                                        </tr>
                                    @empty
                                        <div class="d-flex align-items-center justify-content-center pt-3">
                                            <span class="text-gray-400 text-sm">No existen coincidencias asociadas a su busqueda.</span>
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>