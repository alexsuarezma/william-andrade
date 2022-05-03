<x-app-layout>
    <x-slot name="header">
        Actualizar curso
    </x-slot>
    <!-- <div class="container-md d-flex justify-content-center"> -->
        <!-- general form elements -->
        <section class="content">
            
            <div class="container-fluid">
                <x-toast-message></x-toast-message>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('curso.update.put') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$curso->id}}">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Actualizar curso</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputNombre1">Nombre</label>
                                        <input type="text" name="nombre" value="{{ $curso->nombre }}" class="form-control" id="exampleInputNombre1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputDescripcion1">Descripcion</label>
                                        <textarea name="descripcion" class="form-control" id="exampleInputDescripcion1" required cols="30" rows="10">{{ $curso->descripcion }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputJornada1">Jornada</label>
                                        <input type="text" name="jornada" value="{{ $curso->jornada }}" class="form-control" id="exampleInputJornada1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputNivel1">Nivel</label>
                                        <input type="text" name="nivel" value="{{ $curso->nivel }}" class="form-control" id="exampleInputNivel1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputGrupo1">Grupo</label>
                                        <input type="text" name="grupo" value="{{ $curso->grupo }}" class="form-control" id="exampleInputGrupo1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPeriodo1">Periodo</label>
                                        <input type="text" name="periodo" value="{{ $curso->periodo }}" class="form-control" id="exampleInputPeriodo1" required>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-right">Actualizar curso</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="callout callout-info">
                            <h5>Materias en este curso</h5>
                            <p>Las siguientes materias estan dentro de este curso</p>
                        </div>
                        
                        <div class="card-body table-responsive p-0" style="height: 200px;">
                            <table class="table table-head-fixed text-nowrap"> 
                                <table class="table table-striped projects">
                                    <tbody>
                                        @forelse($curso->materias as $index  => $materia)
                                            <tr>
                                                <td>
                                                    <label class="">
                                                        {{$index + 1 }}
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-around align-items-center">
                                                        <div class="">
                                                            <a>
                                                            {{$materia->nombre}}
                                                            </a>
                                                            <br/>
                                                            <span>{{$materia->docente->name.' '.$materia->docente->lastname}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{$materia->descripcion}}
                                                </td>
                                                <td class="project_progress">
                                                    {{$materia->created_at}}
                                                </td>
                                            </tr>
                                        @empty
                                            <span>No existen materias aun inscritos a este curso</span>
                                        @endforelse
                                    </tbody>
                                </table>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.card -->
    <!-- </div> -->
</x-app-layout>