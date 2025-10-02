<?php

namespace App\Livewire\Instruction;

use Livewire\Component;
use App\Enums\MessageType;
use Livewire\WithPagination;
use App\Services\Instruction\InstructionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search="";
    public string $messageType="received";

    protected InstructionServiceInterface $instruksiService;

    public function boot( InstructionServiceInterface $instruksiService){
        $this->instruksiService=$instruksiService;
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $jenisPesanEnum=MessageType::from($this->messageType);
        $instructions=$this->instruksiService->getAllInstruction($this->search,10,$jenisPesanEnum);

        return view('livewire.instruction.index',[
            'instructions'=>$instructions
        ]);
    }
}
