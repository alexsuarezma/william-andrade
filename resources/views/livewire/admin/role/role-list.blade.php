
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
        @can('rol.crear')
            <div class="col-md-2">
                <a href="{{ route('role.create.get') }}" class="btn btn-outline-success btn-block btn-sm">Crear</a>
            </div>
        @endcan
    </div>
    <div class="card">
        <x-toast-message></x-toast-message>
        <div class="card-header">
            <h3 class="card-title">Roles</h3>

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
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Role
                        </th>
                        <th style="width: 30%">
                            <!-- Team Members -->
                        </th>
                        <th>
                            Created
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                </thead>
                <tbody class="usersTable">
                @forelse($roles as $role)
                    <tr>
                        <td>
                            #{{$role->id}}
                        </td>
                        <td>
                            <a>
                            {{$role->name}}
                            </a>
                        </td>
                        <td>
                            Permisos: 
                                @forelse($role->getAllPermissions() as $permission)
                                    {{$permission->name}}
                                    @if(!$loop->last)
                                        |
                                    @endif
                                @empty
                                    Sin permisos asignados.
                                @endforelse
                        </td>
                        <td class="project_progress">
                            {{$role->created_at}}
                        </td>
                        @can('rol.editar.avanzado')
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('role.update.get', ['id' => $role->id] ) }}">
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
        {{$roles->links()}}
        </div>
        <!-- /.card-body -->
    </div>
</section>