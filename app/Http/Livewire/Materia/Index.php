<?php

namespace App\Http\Livewire\Materia;

use Livewire\Component;
use App\Models\Materia;

use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $filter = '';
    public $status = 0;


    public function render()
    {
        return view('livewire.materia.index',
        [
            'materias' => Materia::where( function($query) {
                                $query->where('nombre', 'LIKE', "%{$this->search}%")->orWhere('descripcion', 'LIKE', "%{$this->search}%")
                                ->orWhere('docente_id', 'LIKE', "%{$this->search}%");
                            })
                            ->where( function($query) {
                                if(\Auth::user()->hasRole(['Docente'])){
                                    $query->where('docente_id', \Auth::user()->id);
                                }
                            })
                            ->paginate(10)
        ]);
    }
}
