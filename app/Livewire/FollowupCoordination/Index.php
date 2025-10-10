<?php

namespace App\Livewire\FollowupCoordination;

use Livewire\Component;
use App\Enums\MessageType;
use App\Models\Coordination;
use App\Models\FollowupCoordination;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use App\Services\FollowupCoordination\FollowupCoordinationServiceInterface;

// class Index extends Component
// {
//     use WithPagination;

//     public string $search = "";
//     public string $messageType= "received";

//     protected FollowupCoordinationServiceInterface $followupCoordinationService;

//     public function boot(FollowupCoordinationServiceInterface $followupCoordinationService){
//         $this->followupCoordinationService = $followupCoordinationService;
//     }

//     public function updatingSearch(){
//         $this->resetPage();
//     }

//     public function render()
//     {
//         $messageTypeEnum=MessageType::from($this->messageType);
//         $followupCoordination=$this->followupCoordinationService->getAll($this->search, $messageTypeEnum, 10);
//         return view('livewire.followup-coordination.index',[
//             'followupCoordinations'=>$followupCoordination
//         ]);
//     }
// }

class index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $switch = 'coordinationMode';

    public ?int $selectedCoordinationId = null;

    public string $messageType = 'received';

    protected $updatesQueryString = ['search', 'messageType'];

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function showFollowups($coordinationId)
    {
        $this->switch = 'followupCoordinationMode';
        $this->selectedCoordinationId = $coordinationId;
        $this->search = "";
        $this->resetPage();
    }

    public function backToCoordinations()
    {
        $this->switch = 'coordinationMode';
        $this->selectedCoordinationId = null;
        $this->resetPage();
    }

    public function goToCreate()
    {
        session(key: ['selectedCoordinationId' => $this->selectedCoordinationId]);
        return redirect()->route('followupcoordination.create');
    }


    public function render()
    {
        if ($this->switch === 'instructionMode') {
            $userId = Auth::id();

            $coordinations = Coordination::with('followups')
                ->where(function ($query) use ($userId) {
                    $query
                        ->where('sender_id', $userId)
                        ->orWhere('receiver_id', $userId)
                        ->orWhereHas('followups', function ($q) use ($userId) {
                            $q->where('receiver_id', $userId); // penerima follow-up
                        })
                        ->orWhereHas('followups.forwards', function ($q) use ($userId) {
                            $q->where('forwarded_to', $userId); // penerima forward follow-up
                        })
                        ->orWhereHas('forwards', function ($q) use ($userId) {
                            $q->where('forwarded_to', $userId); // penerima forward instruction
                        });
                })
                ->when(
                    $this->search,
                    fn($q) =>
                    $q->where(function ($sub) {
                        $sub->where('title', 'like', "%{$this->search}%")
                            ->orWhere('description', 'like', "%{$this->search}%");
                    })
                )
                ->orderByDesc('created_at')
                ->paginate(10);
            
            return view('livewire.followup-coordination.index', compact('instructions'));
        }

        if($this->switch==='followupCoordinationMode' && $this->selectedCoordinationId){
            $userId=Auth::id();
            $followupCoordinations=FollowupCoordination::with(['forwards', 'sender', 'receiver', 'instruction'])
            ->when($this->search, function($query){
                
            })
        }
    }
}
