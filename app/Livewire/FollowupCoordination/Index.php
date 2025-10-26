<?php

namespace App\Livewire\FollowupCoordination;

use Livewire\Component;
use App\Enums\MessageType;
use App\Models\Coordination;
use App\Models\FollowupCoordination;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use App\Services\FollowupCoordination\FollowupCoordinationServiceInterface;


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

        // === MODE Coordination ===
        if ($this->switch === 'coordinationMode') {
            $coordinations = Coordination::withCount([
                'followups as total_followups_count',
                'followups as user_followups_count' => function ($query) use ($userId) {
                    $query->where('sender_id', $userId);
                },
            ])
                ->where(function ($query) use ($userId) {
                    $query
                        ->whereHas('coordinationUsers', function ($q) use ($userId) {
                            $q->where('sender_id', $userId)
                                ->orWhere('receiver_id', $userId);
                        })
                        // Cek follow-up yang ditujukan ke user ini
                        ->orWhereHas('followups', function ($q) use ($userId) {
                            $q->where('receiver_id', $userId);
                        })
                        // Cek follow-up yang diteruskan ke user ini
                        ->orWhereHas('followups.forwards', function ($q) use ($userId) {
                            $q->where('forwarded_to', $userId);
                        })
                        // Cek instruksi yang diteruskan ke user ini
                        ->orWhereHas('forwards', function ($q) use ($userId) {
                            $q->where('forwarded_to', $userId);
                        });
                })
                ->when($this->search, function ($query) {
                    $query->where(function ($sub) {
                        $sub->where('title', 'like', "%{$this->search}%")
                            ->orWhere('description', 'like', "%{$this->search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('livewire.followup-coordination.index', compact('coordinations'));
        }

        // === MODE FOLLOW-UP ===
        if ($this->switch === 'followupCoordinationMode' && $this->selectedCoordinationId) {
            $followupCoordinations = FollowupCoordination::with(['forwards', 'sender', 'receiver', 'coordination'])
                ->where('coordination_id', $this->selectedCoordinationId)
                ->when($this->search, function ($query) {
                    $query->where('description', 'like', '%' . $this->search . '%');
                })
                ->when($this->messageType === 'sent', function ($q) use ($userId) {
                    $q->where('sender_id', $userId);
                })
                ->when($this->messageType === 'received', function ($q) use ($userId) {
                    $q->where(function ($sub) use ($userId) {
                        $sub->where('receiver_id', $userId)
                            ->orWhereHas('forwards', function ($q2) use ($userId) {
                                $q2->where('forwarded_to', $userId);
                            });
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            $coordinationEndTime = Coordination::where('id', $this->selectedCoordinationId)->value('end_time');

            return view('livewire.followup-coordination.index', compact('followupCoordinations', 'coordinationEndTime'));
        }
    }
}
