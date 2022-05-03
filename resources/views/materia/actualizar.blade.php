<x-app-layout>
    <x-slot name="header">
        Actualizar materia
    </x-slot>
    <!-- <div class="container-md d-flex justify-content-center"> -->
        <!-- general form elements -->
        <section class="content">
            
            <div class="container-fluid">
                <x-toast-message></x-toast-message>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('materia.update.put') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$materia->id}}">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Actualizar materia</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputNombre1">Nombre</label>
                                        <input type="text" name="nombre" value="{{ $materia->nombre }}" class="form-control" id="exampleInputNombre1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputNombre1">Docente</label>
                                        <select class="form-control" name="docente_id">
                                            @forelse($docentes as $docente)
                                                <option value="{{$docente->id}}" {{ $materia->docente_id == $docente->id ? 'selected' : '' }}>{{$docente->name.' '.$docente->lastname}}</option>
                                            @empty
                                                <option selected>No hay datos para seleccionar</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputCurso1">Curso</label>
                                        <select class="form-control" name="curso_id">
                                            @forelse($cursos as $curso)
                                                <option value="{{$curso->id}}" {{ $materia->curso_id == $curso->id ? 'selected' : '' }}>{{$curso->nombre}}</option>
                                            @empty
                                                <option selected>No hay datos para seleccionar</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputDescripcion1">Descripcion</label>
                                        <textarea name="descripcion" class="form-control" id="exampleInputDescripcion1" required cols="30" rows="10">{{ $materia->descripcion }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputMalla1">Malla</label>
                                        <input type="text" name="malla_id" value="{{ $materia->malla_id }}" class="form-control" id="exampleInputMalla1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputLinkClase1">Link clase:</label>
                                        <input type="text" name="link_clase" value="{{ $materia->link_clase }}" class="form-control" id="exampleInputLinkClase1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFechaApertura1">Fecha apertura</label>
                                        <input type="date" name="fecha_apertura" value="{{ date('Y-m-d', strtotime($materia->fecha_apertura)) }}" class="form-control" id="exampleInputFechaApertura1" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFechaCierre1">Fecha cierre</label>
                                        <input type="date" name="fecha_cierre" value="{{ date('Y-m-d', strtotime($materia->fecha_cierre)) }}" class="form-control" id="exampleInputFechaCierre1" required>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-right">Actualizar materia</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="callout callout-info">
                            <h5>Usuarios inscritos en esta materia</h5>
                            <p>Los siguientes usuarios (Estudiantes) estan inscritos en esta materia</p>
                        </div>
                        
                        <div class="card-body table-responsive p-0" style="height: 200px;">
                            <table class="table table-head-fixed text-nowrap"> 
                                <table class="table table-striped projects">
                                    <tbody>
                                        @forelse($materia->estudiantes as $index  => $estudiante)
                                            <?php $roleName ='' ;?>
                                            @forelse($estudiante->estudiante->roles as $ur)
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
                                                        {{$index + 1 }}
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-around align-items-center">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                            <img alt="Avatar" class="table-avatar" src="{{$estudiante->estudiante->profile_photo_url}}">
                                                            </li>
                                                        </ul>
                                                        <div class="">
                                                            <a>
                                                            {{$estudiante->estudiante->name.' '.$estudiante->estudiante->lastname}}
                                                            </a>
                                                            <br/>
                                                            <span>{{$estudiante->estudiante->email}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{$roleName}}
                                                </td>
                                                <td class="project_progress">
                                                    {{$estudiante->created_at}}
                                                </td>
                                            </tr>
                                        @empty
                                            <span>No existen estudiantes aun inscritos a este materia</span>
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