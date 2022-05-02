<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class Calendar extends Component
{
    public $anio;

    public function mount(){
        $this->anio = date('Y',strtotime(\Carbon\Carbon::now()));
    }
    public function render()
    {
        return view('livewire.dashboard.calendar',[
            'gastos_produccion' => DB::table('vw_gastos_produccion')->where('anio', $this->anio)->orWhere('exist', 1)->get()
        ]);
    }

    public function sumLessYear($action){
        if($action == 'sum'){
            $this->anio++;
        }else{
            $this->anio--;
        }
    }
}
