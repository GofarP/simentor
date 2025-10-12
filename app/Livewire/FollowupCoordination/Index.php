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

class Index extends Component
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
        session(['selectedCoordinationId' => $this->selectedCoordinationId]);
        return redirect()->route('followupcoordination.create');
    }

    public function render()
    {
        $userId = Auth::id();

        if ($this->switch === 'coordinationMode') {
            $userId = Auth::id();

            $coordinations = Coordination::withCount([
                // Total semua follow-up (untuk pembuat koordinasi)
                'followups as total_followups_count',

                // Follow-up yang dibuat oleh user yang sedang login
                'followups as user_followups_count' => function ($query) use ($userId) {
                    $query->where('sender_id', $userId);
                },
            ])
                ->where(function ($query) use ($userId) {
                    $query
                        ->where('sender_id', $userId) // pembuat koordinasi
                        ->orWhere('receiver_id', $userId) // penerima langsung
                        ->orWhereHas('followups', fn($q) => $q->where('receiver_id', $userId)) // penerima follow-up
                        ->orWhereHas('followups.forwards', fn($q) => $q->where('forwarded_to', $userId)) // penerima forward follow-up
                        ->orWhereHas('forwards', fn($q) => $q->where('forwarded_to', $userId)); // penerima forward koordinasi
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

            return view('livewire.followup-coordination.index', compact('coordinations'));
        }

        if ($this->switch === 'followupCoordinationMode' && $this->selectedCoordinationId) {
            $followupCoordinations = FollowupCoordination::with(['forwards', 'sender', 'receiver', 'coordination'])
                ->where('coordination_id', $this->selectedCoordinationId)
                ->when(
                    $this->search,
                    fn($q) =>
                    $q->where('description', 'like', "%{$this->search}%")
                )
                ->when($this->messageType === 'sent', fn($q) => $q->where('sender_id', $userId))
                ->when($this->messageType === 'received', fn($q) => $q->where('receiver_id', $userId))
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('livewire.followup-coordination.index', compact('followupCoordinations'));
        }

        // default return
        return view('livewire.followup-coordination.index');
    }
}
