
<x-app-layout>
    <x-slot name="header">
        {{Route::is('role.update.get') ? 'Actualizar Rol' : 'Registro de nuevo Rol'}}
    </x-slot>
    @if(empty($role) && Route::is('role.update.get'))
        <div class="w-full h-full flex items-center mt-20 justify-center">
            <span class="text-gray-500 text-lg">
                El Rol no existe...
            </span>
        </div>            
    @else
        <section class="content">
            <!-- general form elements -->
            <form method="POST" action="{{Route::is('role.update.get') ? route('role.update.put') : route('role.create.post')}}">
                @csrf
                @if(Route::is('role.update.get'))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$role->id}}">
                @endif
                <div class="container-fluid">
                    <x-toast-message></x-toast-message>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Información del rol</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputNombres1">Nombre del Rol</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputNombres1" 
                                        value="{{ Route::is('role.update.get') ? $role->name : old('name')}}" required>
                                    </div>
                                </div>
                            </div>
                            @if(Route::is('role.update.get') && isset($role))
                                @if(\Auth::user()->can('rol.asignar') || \Auth::user()->can('rol.revocar'))
                                    <livewire:admin.role.user-selected :users="$users" :role="$role" />
                                @endif
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Permisos</h3>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- checkbox -->
                                        <div class="card-body">
                                            <div class="form-group row row-cols-3">
                                                @forelse($permissions as $permission)
                                                    @if(Route::is('role.update.get'))
                                                        <?php 
                                                            $checked = '';
                                                            foreach($rolePermissions as $rolePermission){
                                                                if($rolePermission->id == $permission->id){
                                                                    $checked = 'checked';
                                                                }
                                                            }
                                                        ?>
                                                    @endif
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" id="{{$permission->name}}" 
                                                        value="{{$permission->id}}" {{Route::is('role.update.get') ? $checked : ''}}>
                                                        <label class="form-check-label" title="{{$permission->name}}" for="{{$permission->name}}">{{$permission->name}}</label>
                                                    </div>
                                                @empty
                                                    <span class="">No hay permisos adicionales disponibles para seleccionar.</span>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(Route::is('role.update.get'))
                                @can('rol.eliminar')
                                    <div class="card card-primary">
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-danger btn-block btn-sm" data-toggle="modal" data-target="#modal-remove-role">Eliminar Rol</button>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                @endcan
                            @endif
                        </div>
                    </div>
                    @if(\Auth::user()->can('rol.editar.avanzado') || \Auth::user()->can('rol.crear'))
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right">{{Route::is('role.update.get') ? 'Actualizar' : 'Crear'}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
            <!-- /.card -->
        </section>

        @if(Route::is('role.update.get'))
            @can('rol.eliminar')
                <div class="modal fade" id="modal-remove-role" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Eliminar Rol</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="{{route('role.delete')}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="role" value="{{$role->id}}">
                                @livewire('admin.role.re-assign', [
                                                                        'roleId' => $role->id,
                                                                    ])
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary"> Eliminar</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            @endcan
        @endif
    @endif
    @if(Route::is('role.update.get'))   
        <script>
            Livewire.on('removeUserInArray', id => {
                if (document.getElementById(id).checked){
                document.getElementById(id).checked = false
                }
            })
        </script>
     @endif
</x-app-layout>