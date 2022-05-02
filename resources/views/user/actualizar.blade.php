<x-app-layout>
    <x-slot name="header">
        Actualizar usuario
    </x-slot>
    @if(!empty($user))
        <div class="container-md d-flex flex-column justify-content-center">
            <!-- general form elements -->
            <div class="card card-primary container">
                <div class="card-header">
                    <h3 class="card-title">Actualizar Usuario</h3>
                </div>
                <!-- /.card-header -->
                <x-toast-message></x-toast-message>
                <!-- form start -->
                <form method="POST" action="{{ route('user.update.put') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputNombres1">Nombres</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" id="exampleInputNombres1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputApellidos1">Apellidos</label>
                            <input type="text" name="lastname" value="{{ $user->lastname }}" class="form-control" id="exampleInputApellidos1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="exampleInputEmail1" required>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="admin" value="1" {{ $user->admin == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleCheck1">Administrador</label>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>

            <div class="card card-primary container">
                <div class="card-header">
                    <h3 class="card-title">Actualizar Contraseña</h3>
                </div>
                <!-- form start -->
                <form method="POST" action="{{ route('user.update.password.put') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Contraseña</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPasswordconfirmation1">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" id="exampleInputPasswordconfirmation1" required>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    @else
        <x-error404></x-error404>
    @endif
</x-app-layout>