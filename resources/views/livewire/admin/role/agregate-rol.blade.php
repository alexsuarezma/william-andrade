<div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Roles</h3>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <!-- checkbox -->
                <div class="card-body">
                    <div class="form-group">
                        @forelse($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" 
                                    @if(Route::is('user.update')) @if(array_search($role->id, array_column($rolesSelected, 'id')) !== false) checked @endif @endif
                                    value="{{$role->id}}" id="{{$role->id}}" wire:click="addRoleInArray({{$role->id}},'{{$role->name}}')"> 
                                <label class="form-check-label" for="{{$role->id}}">{{$role->name}}</label>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Permisos adicionales</h3>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <!-- checkbox -->
                <div class="card-body">
                    <div class="form-group {{ count($remainingPermissions) > 0 ? 'row row-cols-3' : '' }}">
                        @forelse($remainingPermissions as $permission)
                            @if(Route::is('user.update'))
                                <?php 
                                    $checked = '';
                                    foreach($userPermissions as $userPerm){
                                        if($userPerm->id == $permission->id){
                                            $checked = 'checked';
                                        }
                                    }
                                ?>
                            @endif
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{$permission->id}}" id="{{$permission->name}}"
                                    {{Route::is('user.update') ? $checked : ''}}>
                                <label class="form-check-label" for="{{$permission->name}}">{{$permission->name}}</label>
                            </div>
                        @empty
                            <span class="">No hay permisos adicionales disponibles para seleccionar.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>