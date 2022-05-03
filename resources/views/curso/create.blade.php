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
                        <h3 class="card-title">Registrar curso</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputNombre1">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" id="exampleInputNombre1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDescripcion1">Descripcion</label>
                            <textarea name="descripcion" class="form-control" id="exampleInputDescripcion1" required cols="30" rows="10">{{ old('descripcion') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputJornada1">Jornada</label>
                            <input type="text" name="jornada" value="{{ old('jornada') }}" class="form-control" id="exampleInputJornada1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputNivel1">Nivel</label>
                            <input type="text" name="nivel" value="{{ old('nivel') }}" class="form-control" id="exampleInputNivel1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputGrupo1">Grupo</label>
                            <input type="text" name="grupo" value="{{ old('grupo') }}" class="form-control" id="exampleInputGrupo1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPeriodo1">Periodo</label>
                            <input type="text" name="periodo" value="{{ old('periodo') }}" class="form-control" id="exampleInputPeriodo1" required>
                        </div>
                        
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Crear curso</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    <!-- </div> -->
</x-app-layout>