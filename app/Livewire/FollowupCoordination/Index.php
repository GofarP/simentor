<?php

namespace App\Livewire\FollowupCoordination;

use App\Enums\MessageType;
use Livewire\Component;
use Livewire\WithPagination;

use App\Services\FollowupCoordination\FollowupCoordinationServiceInterface;

class Index extends Component
{
    use WithPagination;

    protected string $search = "";
    public string $messageType = "received";

    protected FollowupCoordinationServiceInterface $followupInstructionService;

    public function boot(FollowupCoordinationServiceInterface $followupInstructionService){
        $this->followupInstructionService = $followupInstructionService;
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $messageEnum=MessageType::from($this->messageType);
        $followupCoordination=$this->followupInstructionService->getAll($this->search, $messageEnum, 10);
        return view('livewire.followup-coordination.index',[
            'followupcoordinations'=>$followupCoordination
        ]);
    }
}
