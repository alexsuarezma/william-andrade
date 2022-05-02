<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <section class="content">
        <!-- general form elements -->
        <div class="container-fluid">
            <x-toast-message></x-toast-message>
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Información Personal</h3>
                            
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('user.profile.information.update')}}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <p>Utilice un correo electronico donde pueda recibir todas las notificaciones.</p>
                                <div class="form-group">
                                    <label for="exampleInputNombres1">Nombres</label>
                                    <input type="text" name="name" class="form-control" id="exampleInputNombres1" 
                                    value="{{ \Auth::user()->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputApellidos1">Apellidos</label>
                                    <input type="text" name="lastname" class="form-control" id="exampleInputApellidos1" 
                                    value="{{ \Auth::user()->lastname }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUserName1">Nombre de usuario</label>
                                    <input type="text" name="username" class="form-control" id="exampleInputUserName1" 
                                    value="{{ \Auth::user()->username }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" 
                                    value="{{ \Auth::user()->email }}" required>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Actualizar Contraseña</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('update.password.verification') }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <p>Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.</p>
                                <div class="form-group">
                                    <label for="exampleInputContrasenaAnterior">Contraseña Anterior</label>
                                    <input type="password" name="current_password" class="form-control" id="exampleInputContrasenaAnterior" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputNuevaContrasena1">Nueva Contraseña</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputNuevaContrasena1" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputConfirmaContrasena1">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="exampleInputConfirmaContrasena1" required>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
</x-app-layout>
