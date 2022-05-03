<x-app-layout>
    <x-slot name="header">
        Información de la materia
    </x-slot>
    <section class="content">
        <x-toast-message></x-toast-message>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalles de la materia</h3>

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
                                        <span class="info-box-text text-center text-muted">Estudiantes inscritos</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{count($materia->estudiantes)}}</span>
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
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Docente encargado</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{$materia->docente->name.' '.$materia->docente->lastname}}</span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Lista de estudiantes</h4>

                                @forelse($materia->estudiantes as $index  => $estudiante)
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{$estudiante->estudiante->profile_photo_url}}" alt="user image">
                                        <span class="username">
                                            <a href="#">{{$estudiante->estudiante->name.' '.$estudiante->estudiante->lastname}}</a>
                                        </span>
                                        <span class="description">{{$estudiante->estudiante->email}} - {{$estudiante->created_at}}</span>
                                    </div>
                                </div>
                                @empty
                                    <span class="description">No existen estudiantes aun inscritos a este materia</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary">{{$materia->nombre}}</h3>
                        <p class="text-muted">{{$materia->descripcion}}</p>
                        <br>
                        <div class="text-muted">
                            <p class="text-sm">Fecha Apertura
                                <b class="d-block">{{$materia->fecha_apertura}}</b>
                            </p>
                            <p class="text-sm">Fecha Cierre
                                <b class="d-block">{{$materia->fecha_cierre}}</b>
                            </p>
                            <p class="text-sm">Curso
                                <b class="d-block">
                                    <a href="{{ route('curso.info', ['id' => $materia->curso->id] ) }}" target="_blank" rel="noopener noreferrer">{{$materia->curso->nombre}}</a>
                                </b>
                            </p>
                        </div>
                        <p>
                            <a href="{{$materia->link_clase}}"  target="_blank" rel="noopener noreferrer" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Link directo</a>
                        </p>
                        <div class="row">
                            @if($estudiante_existe)
                            <div class="col-md-6">
                                <div class="text-left mt-5 mb-3">
                                    <a href="{{$materia->link_clase}}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-info">Ingresar a la clase</a>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                @if(!$estudiante_existe)
                                    @can('materia.inscribirse')
                                        <div class="text-right mt-5 mb-3">
                                            <form method="POST" action="{{ route('materia.inscribirse.post') }}">
                                                @csrf
                                                <input type="hidden" name="materia_id" value="{{$materia->id}}">
                                                <button class="btn btn-sm btn-success">Inscribirme a este materia</button>
                                            </form>
                                        </div>
                                    @endcan
                                @else
                                    @can('materia.salir')
                                        <div class="text-right mt-5 mb-3">
                                            <form method="POST" action="{{ route('materia.salir.post') }}">
                                                @csrf
                                                <input type="hidden" name="materia_id" value="{{$materia->id}}">
                                                <button class="btn btn-sm btn-danger">Salir de este materia</button>
                                            </form>
                                        </div>
                                    @endcan
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
</x-app-layout>