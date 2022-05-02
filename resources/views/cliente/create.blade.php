<x-app-layout>
    <x-slot name="header">
        Registrar nuevo cliente
    </x-slot>
    <!-- <div class="container-md d-flex justify-content-center"> -->
        <!-- general form elements -->
        <div class="container">
            <x-toast-message></x-toast-message>
            <form method="POST" action="{{ route('cliente.create.post') }}">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Cliente</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tipo_cliente">Tipo Cliente</label>
                            <select class="custom-select" id="tipo_cliente" name="tipo_cliente">
                                <option value="1" {{ old('tipo_cliente') == 1 ? 'selected' : '' }}>Local</option>
                                <option value="2" {{ old('tipo_cliente') == 2 ? 'selected' : '' }}>Extranjero</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCedula1">Cedula</label>
                            <input type="text" name="cedula" value="{{ old('cedula') }}" id="cedula" onkeypress="return soloNumeros(event)" class="form-control" id="exampleInputCedula1" required>
                            <div class="invalid-feedback">
                                Cedula invalida.
                            </div>
                            <div class="valid-feedback">
                                Cedula valida.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputNombres1">Nombres</label>
                            <input type="text" name="nombres" value="{{ old('nombres') }}" class="form-control" id="exampleInputNombres1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputApellidos1">Apellidos</label>
                            <input type="text" name="apellidos" value="{{ old('apellidos') }}" class="form-control" id="exampleInputApellidos1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="exampleInputEmail1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDireccion1">Dirección</label>
                            <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control" id="exampleInputDireccion1" required>
                        </div>
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="form-control" onkeypress="return soloNumeros(event)" required/>
                            <div class="invalid-feedback">
                                Debe de ser un numero de 7 digítos
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Celular</label>
                            <input type="text" name="celular" id="celular" value="{{ old('celular') }}" onkeypress="return soloNumeros(event)" class="form-control"  required/>
                            <div class="invalid-feedback">
                                Debe de ser un numero de 10 digítos y debe empezar a 0
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Crear Cliente</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    <!-- </div> -->
    <script>
        document.getElementById('telefono').addEventListener('change', () => {
            const input = document.getElementById('telefono')
            const resolve = validarTelefono(input)
            const classBad = ['is-invalid']

            if(!resolve){
                input.value = ''
                classBad.forEach((cls) => input.classList.add(cls))
            }else{
                classBad.forEach((cls) => input.classList.remove(cls))
            }
        })

        document.getElementById('celular').addEventListener('change', () => {
            const input = document.getElementById('celular')
            const resolve = validarCelular(input)
            const classBad = ['is-invalid']
            if(!resolve){
                input.value = ''
                classBad.forEach((cls) => input.classList.add(cls))
            }else{
                classBad.forEach((cls) => input.classList.remove(cls))
            }
        })
        
        document.getElementById('cedula').addEventListener('change', () => {
            const input = document.getElementById('cedula')
            const resolve = verificarCedula(input)
            const classBad = ['is-invalid']
            const classOk = ['is-valid']

            if(!resolve){
                input.value = ''
                classBad.forEach((cls) => input.classList.add(cls))
                classOk.forEach((cls) => input.classList.remove(cls))
            }else{
                classBad.forEach((cls) => input.classList.remove(cls))
                classOk.forEach((cls) => input.classList.add(cls))
            }
        })
        
    </script>
</x-app-layout>