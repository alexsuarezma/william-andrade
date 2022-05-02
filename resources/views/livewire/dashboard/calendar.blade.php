<div class="col-md-8">
    <!-- MAP & BOX PANE -->
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Calendario</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
            </button>
        </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
        <p class="text-center">
            <i class="fas fa-caret-left mr-2" style="cursor:pointer;" wire:click="sumLessYear('less')"></i>
            <strong>{{ '1 Ene ,'.$anio.' - '.'31 Dic ,'.$anio }}</strong>
            <i class="fas fa-caret-right ml-2" style="cursor:pointer;" wire:click="sumLessYear('sum')"></i>
        </p>
        <div class="container p-4">
            <div class="row">
            @for($i=1; $i <= 12; $i++)
                <div class="col-md-3 border d-flex flex-column justify-content-center align-items-center border border-warning rounded" 
                    style="border-radius: 25px; color: white; font-weight: bold; min-height:150px; background-color:
                    @if($i == 1 || $i == 2) #B27F00; @elseif($i == 3 || $i == 4) #228D00; @elseif($i == 5 || $i == 6) #00808D;
                    @elseif($i == 7 || $i == 8) #003A8D; @elseif($i == 9 || $i == 10) #8D2600; @elseif($i == 11 || $i == 12) #5B0015; @endif">
                    @switch($i)
                        @case(1)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 1)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb </br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Enero</h5>
                            @break
                        @case(2)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 2)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Febrero</h5>
                            @break
                        @case(3)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 3)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Marzo</h5>
                            @break
                        @case(4)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 4)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Abril</h5>
                            @break
                        @case(5)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 5)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Mayo</h5>
                            @break
                        @case(6)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 6)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Junio</h5>
                            @break
                        @case(7)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 7)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Julio</h5>
                            @break
                        @case(8)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 8)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Agosto</h5>
                            @break
                        @case(9)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 9)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Septiembre</h5>
                            @break
                        @case(10)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 10)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Octubre</h5>
                            @break
                        @case(11)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 11)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Noviembre</h5>
                            @break
                        @case(12)
                            @foreach($gastos_produccion as $detail)
                            @if($detail->month == 12)
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                <div>
                                    G. ${{$detail->gastos}} | P. {{$detail->produccion}}lb</br>
                                    | P.L. {{$detail->p_local}}caj. | P.E. {{$detail->p_exportacion}}caj.
                                </div>
                                {{$detail->nombre_lote}}
                                </div>
                            @endif
                            @endforeach
                            <br>
                            <h5 class="description-header">Diciembre</h5>
                            @break
                    @endswitch
                </div>
            @endfor
            </div>
        </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>
