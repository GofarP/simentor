<?php

namespace App\Livewire\FollowupInstruction;

use Livewire\Component;
use Livewire\WithPagination;
use App\Enums\MessageType;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search="";
    public $messageType="received";

    protected FollowupInstructionServiceInterface $followupInstructionService;

    public function boot(FollowupInstructionServiceInterface $followupInstructionService){
        $this->followupInstructionService=$followupInstructionService;
    }


    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $messageTypeEnum=MessageType::from($this->messageType);
        $followupInstruction=$this->followupInstructionService->getAll($this->search,$messageTypeEnum,10);
        return view('livewire.followup-instruction.index',[
            'followupInstructions'=>$followupInstruction
        ]);
    }
}
