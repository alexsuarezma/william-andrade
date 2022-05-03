<x-app-layout>
    <x-slot name="header">
        Información del curso
    </x-slot>
    <section class="content">
        <x-toast-message></x-toast-message>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalles del curso</h3>

                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Materias del curso</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{count($curso->materias)}}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Total amount spent</span>
                                        <span class="info-box-number text-center text-muted mb-0">2000</span>
                                    </div>
                                </div>
                            </div>
                            -->
                            {{--<div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Docente encargado</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{$curso->docente->name.' '.$curso->docente->lastname}}</span>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Lista de materias</h4>

                                @forelse($curso->materias as $index  => $materia)
                                <div class="post">
                                    <div class="user-block">
                                        <span class="username">
                                            <a href="#">{{$materia->nombre}}</a>
                                        </span>
                                        <span class="description">{{$materia->docente->name}} - {{$materia->created_at}}</span>
                                    </div>
                                </div>
                                @empty
                                    <span class="description">No existen materias aun inscritos a este curso</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary">{{$curso->nombre}}</h3>
                        <p class="text-muted">{{$curso->descripcion}}</p>
                        <br>
                        <div class="text-muted">
                            <p class="text-sm">Grupo
                                <b class="d-block">{{$curso->grupo}}</b>
                            </p>
                            <p class="text-sm">Jornada
                                <b class="d-block">{{$curso->jornada}}</b>
                            </p>
                            <p class="text-sm">Periodo
                                <b class="d-block">{{$curso->periodo}}</b>
                            </p>
                            <p class="text-sm">Nivel
                                <b class="d-block">{{$curso->nivel}}</b>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
</x-app-layout>