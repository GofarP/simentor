<?php

namespace App\Livewire\Instruksi;

use App\Services\Permission\PermissionServiceInterface;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Instruksi\InstruksiServiceInterface;
class Index extends Component
{
    use WithPagination;

    public string $search="";

    protected InstruksiServiceInterface $instruksiService;

    public function boot( InstruksiServiceInterface $instruksiService){
        $this->instruksiService=$instruksiService;
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $instruksis=$this->instruksiService->getAllInstruksi($this->search,10);

        return view('livewire.instruksi.index',[
            'instruksis'=>$instruksis
        ]);
    }
}
