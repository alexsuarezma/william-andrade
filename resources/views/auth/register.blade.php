{{--<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>--}}

<x-app-layout>
    <x-slot name="header">
        Registrar nuevo usuario
    </x-slot>
    @if(empty($user) && Route::is('user.update'))
        <div class="w-full h-full flex items-center mt-20 justify-center">
            <span class="text-gray-500 text-lg">
                El Usuario no existe...
            </span>
        </div>            
    @else
        <section class="content">
            <!-- general form elements -->
            <form method="POST" action="{{Route::is('user.update') ? route('user.information.update') : route('user.create.post')}}">
                @csrf
                @if(Route::is('user.update'))
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$user->id}}">
                @endif
                <div class="container-fluid">
                    <x-toast-message></x-toast-message>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Registrar Usuario</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <!-- <form method="POST" action="{{ route('user.create.post') }}"> -->
                                    
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputNombres1">Nombres</label>
                                            <input type="text" name="name" class="form-control" id="exampleInputNombres1" 
                                            value="{{ Route::is('user.update') ? $user->name : old('name')}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputApellidos1">Apellidos</label>
                                            <input type="text" name="lastname" class="form-control" id="exampleInputApellidos1" 
                                            value="{{ Route::is('user.update') ? $user->lastname : old('lastname')}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUserName1">Nombre de usuario</label>
                                            <input type="text" name="username" class="form-control" id="exampleInputUserName1" 
                                            value="{{ Route::is('user.update') ? $user->username : old('username')}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" 
                                            value="{{ Route::is('user.update') ? $user->email : old('email')}}" required>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="exampleInputPassword1">Contraseña</label>
                                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" 
                                            value="{{ Route::is('user.update') ? $user->name : old('name')}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPasswordconfirmation1">Confirmar Contraseña</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="exampleInputPasswordconfirmation1" 
                                            value="{{ Route::is('user.update') ? $user->name : old('name')}}" required>
                                        </div> -->
                                        <!-- <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="admin" value="1" {{ old('admin') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="exampleCheck1">Administrador</label>
                                        </div> -->
                                    </div>
                                    <!-- /.card-body -->
                                    <!-- <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right">Guardar</button>
                                    </div> -->
                                <!-- </form> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if(Route::is('user.update'))
                                @livewire('admin.role.agregate-rol', [
                                                                        'roles' => $roles,
                                                                        'rolesSelected' => $rolesSelected,
                                                                        'idRoles' => $idRoles,
                                                                        'userPermissions' => $userPermissions,
                                                                    ])
                            @else
                                <livewire:admin.role.agregate-rol :roles="$roles"/>
                            @endif
                            @if(Route::is('user.update'))
                                <div class="card card-primary">
                                    <div class="card-footer">
                                        <div class="row row-cols-2">
                                            <div class="col">
                                                <button type="button" class="btn btn-block btn-outline-secondary btn-sm" data-toggle="modal" data-target="#modal-change-password-user">Cambiar contraseña</button>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-outline-{{ $user->active == 1 ? 'danger' : 'success'}} btn-block btn-sm" data-toggle="modal" data-target="#modal-desactive-active-user">{{ $user->active == 1 ? 'Desactivar' : 'Activar'}} esta cuenta</button>
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-right">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.card -->
        </section>

        @if(Route::is('user.update'))
            <div class="modal fade" id="modal-desactive-active-user" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title"> {{ $user->active == 1 ? 'Desactivar' : 'Activar'}} Cuenta</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        </div>
                        <form action="{{route('user.desactive.account')}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <p>¿Estás seguro de que deseas {{ $user->active == 1 ? 'desactivar' : 'activar'}} las cuentas seleccionadas? Una vez que {{ $user->active == 1 ? 'desactive' : 'active'}} la cuenta, se {{ $user->active == 1 ? 'negara' : 'permitira'}}  el acceso del usuario a la plataforma. 
                                <br><br>
                                    Ingrese su contraseña para confirmar que desea {{ $user->active == 1 ? 'desactivar' : 'activar'}} la cuenta.</p>
                                <input type="hidden" name="id[]" value="{{$user->id}}">
                                <input type="hidden" name="active[]" value="{{$user->active == 1 ? 0 : 1}}">
                                <input type="password" name="password" class="form-control" placeholder="Tu contraseña, para confirmar" required>
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary"> {{ $user->active == 1 ? 'Desactivar' : 'Activar'}}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="modal-change-password-user" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Cambiar contraseñas en cuentas seleccionadas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    </div>
                    <form action="{{route('user.passwords.update')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <p>¿Estás seguro de que deseas cambiar la contraseña del usuario {{$user->name.' '.$user->lastname}}?. </p>
                            <input type="hidden" name="id[]" value="{{$user->id}}">
                            <input type="password" name="passwordUsers" class="form-control" placeholder="Nueva Contraseña" required>
                        </div>
                        <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        @endif
    @endif
</x-app-layout>