<?php

namespace App\Livewire\FollowupCoordination;

use App\Enums\MessageType;
use Livewire\Component;
use Livewire\WithPagination;

use App\Services\FollowupCoordination\FollowupCoordinationServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = "";
    public string $messageType= "received";

    protected FollowupCoordinationServiceInterface $followupCoordinationService;

    public function boot(FollowupCoordinationServiceInterface $followupCoordinationService){
        $this->followupCoordinationService = $followupCoordinationService;
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $messageTypeEnum=MessageType::from($this->messageType);
        $followupCoordination=$this->followupCoordinationService->getAll($this->search, $messageTypeEnum, 10);
        return view('livewire.followup-coordination.index',[
            'followupCoordinations'=>$followupCoordination
        ]);
    }
}
