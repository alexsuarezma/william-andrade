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
        <!-- <div class="col-md-2">
            <div class="form-group">
                <select class="custom-select" wire:model="status">
                    <option value="0">Todos</option>
                    <option value="1">Local</option>
                    <option value="2">Exterior</option>
                </select>
            </div>
        </div> -->
    </div>
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Materias</h3>

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
                            Nombre
                        </th>
                        <th style="width: 30%">
                            Descripción
                        </th>
                        <th style="width: 30%">
                            Docente
                        </th>
                        <th>
                            Fecha Apertura
                        </th>
                        <th style="width: 8%" class="text-center">
                            Fecha Cierre
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                </thead>
                <tbody>
                @forelse($materias as $materia)
                    <tr>
                        <td>
                            #{{$materia->id}}
                        </td>
                        <td>
                            <a>
                                {{$materia->nombre}}
                            </a>
                        </td>
                        <td>
                            {{$materia->descripcion}}
                        </td>
                        <td>
                            {{ $materia->docente->name.' '.$materia->docente->lastname }}
                        </td>
                        <td>
                            {{$materia->fecha_apertura}}
                        </td>
                        <td>
                            {{$materia->fecha_cierre}}
                        </td>
                        <td class="project-actions text-right">
                            @if(\Auth::user()->hasRole(['Estudiante']))
                                <a class="btn btn-info btn-sm" href="{{ route('materia.info', ['id' => $materia->id] ) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                    Ver materia
                                </a>
                            @endif
                            @if(\Auth::user()->can('materia.editar.avanzado'))
                                <a class="btn btn-info btn-sm" href="{{ route('materia.update', ['id' => $materia->id] ) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Editar
                                </a>
                            @endif
                            <!-- <a class="btn btn-danger btn-sm" href="#">
                                <i class="fas fa-trash">
                                </i>
                                Eliminar
                            </a> -->
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        {{$materias->links()}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>