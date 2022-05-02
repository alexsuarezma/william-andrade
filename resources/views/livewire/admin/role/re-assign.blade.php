<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="callout callout-info">
                <h5>Reasignar Rol a usuarios afectados</h5>

                <p>Si deseas puedes asignarles un nuevo rol a los usuarios afectados</p>
            </div>
            <select onchange="changeRole(this)" name="newRole" class="form-control" required>
                <option disabled selected>Seleccione un rol</option>
                @forelse($roles as $rol)
                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                @empty
                    <option selected diabled>No hay roles configurados</option>
                @endforelse
            </select>
        </div>
        <div class="col-md-6">
            <div class="form-group row row-cols-3">
                @if(isset($permissionNewRole))
                    @forelse($permissionNewRole->getAllPermissions() as $permiss)
                        <div class="form-check">
                            <label class="form-check-label" title="{{$permiss->name}}">{{$permiss->name}}</label>
                        </div>
                    @empty
                        <span class="">Este rol no tiene permisos asignados</span>
                    @endforelse
                @else
                    <span class="">Aun no has seleccionado un rol.</span>
                @endif
            </div>
        </div>
    </div>
    <script>
        function changeRole(input){
            window.livewire.emit('selectNewRole', input.value)
        }
    </script>
</div>