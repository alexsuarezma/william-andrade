<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Models\Gasto;
use App\Models\Produccion;
use App\Models\Venta;

use Carbon\Carbon;

class ChartYearAnalitic extends Component
{
    public $anio;
    public $datos_gastos = array();
    public $datos_ventas = array();

    protected $listeners = ['renderChart'];

    public function mount(){
        $this->anio = date('Y',strtotime(\Carbon\Carbon::now()));
        $this->subject();
    }
    
    public function render()
    {

        return view('livewire.dashboard.chart-year-analitic',[
            'produccion_total' => Produccion::select(DB::raw("ifnull(sum(produccion.total_produccion),0) as produccion"))
                    ->where('anulado', 0)
                    ->whereYear('fecha_documento', $this->anio)
                    ->first(),
            'venta_total' => Venta::select(DB::raw("ifnull(sum(ventas.total_venta),0) as venta"))
                    ->where('anulado', 0)
                    ->whereYear('fecha_documento', $this->anio)
                    ->first(),
            'gastos_total' => Gasto::select(DB::raw("ifnull(sum(gastos.total_gasto),0) as gastos"))
                    ->where('anulado', 0)
                    ->whereYear('fecha_documento', $this->anio)
                    ->first(),
        ]);

        
    }

    public function sumLessYear($action){
        
        if($action == 'sum'){
            $this->anio++;
        }else{
            $this->anio--;
        }

        $gastos_ventas = DB::table('vw_gastos_ventas')->where('anio', $this->anio)->get();

        $datos_gastos = array();
        $datos_ventas = array();
        
        foreach($gastos_ventas as $ga){
            array_push($datos_gastos, $ga->gastos);
            array_push($datos_ventas, $ga->ventas);
        }

        $this->data = array(
            'labels' => ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            'datasets' => array( 
                array(         
                    'label' => 'Gastos',
                    'backgroundColor'=> 'rgba(60,141,188,0.9)',
                    'borderColor'=> 'rgba(60,141,188,0.8)',
                    'pointColor'=> '#3b8bba',
                    'fill'=> false,
                    'tension'=> 0.1,
                    'data' => $datos_gastos
                ),
                array(         
                    'label' => 'Ventas',
                    'backgroundColor'=> 'rgba(210, 214, 222, 1)',
                    'borderColor'=> 'rgba(210, 214, 222, 1)',
                    'pointColor'=> 'rgba(210, 214, 222, 1)',
                    'fill'=> false,
                    'tension'=> 0.1,
                    'data' => $datos_ventas
                )
            )
        );
          
        $this->emit('renderChart', $this->data);
    }

    public function subject(){
        $gastos_ventas = DB::table('vw_gastos_ventas')->where('anio', $this->anio)->get();

        $this->datos_gastos = array();
        $this->datos_ventas = array();
        
        foreach($gastos_ventas as $ga){
            array_push($this->datos_gastos, $ga->gastos);
            array_push($this->datos_ventas, $ga->ventas);
        }

        return; 
    }

    public function renderChart($data){ return; }

}
