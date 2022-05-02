<x-app-layout>
    <x-slot name="header">
        Registrar nuevo curso
    </x-slot>
    <!-- <div class="container-md d-flex justify-content-center"> -->
        <!-- general form elements -->
        <div class="container">
            <x-toast-message></x-toast-message>
            <form method="POST" action="{{ route('curso.create.post') }}">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Curso</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputNombre1">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" id="exampleInputNombre1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputNombre1">Docente</label>
                            <select class="form-control" name="docente_id">
                                @forelse($docentes as $docente)
                                    <option value="{{$docente->id}}" {{ old('docente_id') ? ( old('docente_id') == $docente->id ? 'selected' : '' ) : '' }}>{{$docente->name.' '.$docente->lastname}}</option>
                                @empty
                                    <option selected>No hay datos para seleccionar</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDescripcion1">Descripcion</label>
                            <textarea name="descripcion" class="form-control" id="exampleInputDescripcion1" required cols="30" rows="10">{{ old('descripcion') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputLinkClase1">Link clase:</label>
                            <input type="text" name="link_clase" value="{{ old('link_clase') }}" class="form-control" id="exampleInputLinkClase1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFechaApertura1">Fecha apertura</label>
                            <input type="date" name="fecha_apertura" value="{{ old('fecha_apertura') }}" class="form-control" id="exampleInputFechaApertura1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFechaCierre1">Fecha cierre</label>
                            <input type="date" name="fecha_cierre" value="{{ old('fecha_cierre') }}" class="form-control" id="exampleInputFechaCierre1" required>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Crear Curso</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    <!-- </div> -->
</x-app-layout>