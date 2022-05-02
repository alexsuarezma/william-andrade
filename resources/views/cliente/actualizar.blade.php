<x-app-layout>
    <x-slot name="header">
        Actualizar cliente
    </x-slot>
    @if(!empty($cliente))
    <div class="container">
        <!-- Columns are always 50% wide, on mobile and desktop -->
        <div class="row">
            <div class="col-8">
                <!-- general form elements -->
                <x-toast-message></x-toast-message>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Actualizar Cliente</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('cliente.update.put') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{$cliente->id}}">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tipo_cliente">Tipo Cliente</label>
                                <select class="custom-select" id="tipo_cliente" name="tipo_cliente">
                                    <option value="1" {{ $cliente->tipo_cliente == 1 ? 'selected' : '' }}>Local</option>
                                    <option value="2" {{ $cliente->tipo_cliente == 2 ? 'selected' : '' }}>Extranjero</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCedula1">Cedula</label>
                                <input type="text" disabled name="cedula" value="{{ $cliente->cedula }}" id="cedula" onkeypress="return soloNumeros(event)" class="form-control" id="exampleInputCedula1" required>
                                <div class="invalid-feedback">
                                    Cedula invalida.
                                </div>
                                <div class="valid-feedback">
                                    Cedula valida.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputNombres1">Nombres</label>
                                <input type="text" name="nombres" value="{{ $cliente->nombres }}" class="form-control" id="exampleInputNombres1" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputApellidos1">Apellidos</label>
                                <input type="text" name="apellidos" value="{{ $cliente->apellidos }}" class="form-control" id="exampleInputApellidos1" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" value="{{ $cliente->email }}" class="form-control" id="exampleInputEmail1" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputDireccion1">Dirección</label>
                                <input type="text" name="direccion" value="{{ $cliente->direccion }}" class="form-control" id="exampleInputDireccion1" required>
                            </div>
                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" name="telefono" value="{{ $cliente->telefono }}" class="form-control" onkeypress="return soloNumeros(event)" required/>
                                <div class="invalid-feedback">
                                    Debe de ser un numero de 7 digítos
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Celular</label>
                                <input type="text" name="celular" value="{{ $cliente->celular }}" class="form-control" onkeypress="return soloNumeros(event)" required/>
                                <div class="invalid-feedback">
                                    Debe de ser un numero de 10 digítos y debe empezar a 0
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Actualizar Cliente</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->      
            </div>
            <div class="col-4">
                <!-- general form elements -->
                <div class="card card-primary container">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-ventas">
                        Registrar venta
                    </button>
                </div>
                <div class="container">
                    <div class="card card-info">
                        <div class="card-header">
                        <h3 class="card-title">Lista Ventas</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Fecha Emision</th>
                                    <th>Valor</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    {{--@forelse($cliente->cobros as $cobro)
                                        <tr>
                                            <td>{{$cobro->fecha}}</td>
                                            <td>{{$cobro->coste}}</td>
                                            <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <a href="#modal-cobro-{{$cobro->id}}" data-toggle="modal" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                            </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modal-cobro-{{$cobro->id}}">
                                            <div class="modal-dialog modal-ventas">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h4 class="modal-title">Registro de cobros a cliente {{$cliente->nombres.' '.$cliente->apellidos}}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputDescripcion1">Descripcion</label>
                                                            <textarea disabled class="form-control" id="exampleInputDescripcion1" cols="5" rows="5">{{ $cobro->descripcion }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputValor1">Valor</label>
                                                            <input type="text" disabled value="{{ $cobro->coste }}" class="form-control" id="exampleInputValor1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputFecha1">Fecha</label>
                                                            <input type="date" disabled value="{{ $cobro->fecha }}" class="form-control" id="exampleInputFecha1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputDireccion1">Dirección</label>
                                                            <input type="text" disabled value="{{ $cobro->direccion }}" class="form-control" id="exampleInputDireccion1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <form action="{{ route('cobro.delete') }}" method="POST">
                                                        @csrf   
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{$cobro->id}}">
                                                        <button type="submit" class="btn btn-danger">Anular cobro</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    @empty
                                    @endforelse--}}
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card -->      
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-ventas">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Registro de venta a cliente {{$cliente->nombres.' '.$cliente->apellidos}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputDescripcion1">Descripcion</label>
                            <textarea name="descripcion" value="{{ old('descripcion') }}" class="form-control" id="exampleInputDescripcion1" required cols="5" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputValor1">Valor</label>
                            <input type="text" name="coste" value="{{ old('coste') }}" class="form-control" id="exampleInputValor1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFecha1">Fecha</label>
                            <input type="date" name="fecha" value="{{ old('fecha') }}" class="form-control" id="exampleInputFecha1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDireccion1">Dirección</label>
                            <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-control" id="exampleInputDireccion1" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar venta</button>
                </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
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
    @else
        <x-error404></x-error404>
    @endif
</x-app-layout>