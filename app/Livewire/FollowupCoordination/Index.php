<?php

namespace App\Livewire\FollowupCoordination;

use Carbon\Carbon;
use Livewire\Component;
use App\Enums\MessageType;
use App\Models\Coordination;
use Livewire\WithPagination;

use App\Models\FollowupCoordination;
use App\Services\Coordination\CoordinationServiceInterface;
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

    protected CoordinationServiceInterface $coordinationService;
    protected FollowupCoordinationServiceInterface $followupCoordinationService;

    public function boot(FollowupCoordinationServiceInterface $followupCoordinationService,CoordinationServiceInterface $coordinationService)
    {
        $this->coordinationService = $coordinationService;
        $this->followupCoordinationService = $followupCoordinationService;
    }

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

        $coordinations = null;
        $followupcoordinations = null;
        $coordination = null;
        $firstFollowup = null;
        $receiverId = null;
        $senderId = null;
        $forwardedTo = [];
        $endTime = null;

        $messageTypeEnum = MessageType::tryFrom($this->messageType) ?? MessageType::Received;

        if ($this->switch === 'coordinationMode') {

            $coordinations = $this->coordinationsService->getCoordinationsWithFollowupCounts(
                $this->search,
                10
            );
        }

        if ($this->switch === 'followupCoordinationMode' && $this->selectedCoordinationId) {

            // Panggil Repository Followup
            $followupcoordinations = $this->followupCoordinationService->getAll(
                $this->selectedCoordinationId,
                $this->search,
                $messageTypeEnum,
                10,
                true
            );

            $coordination = Coordination::where('id', $this->selectedCoordinationId)->first();
            $firstFollowup = $followupcoordinations->first();
            $receiverId = optional($firstFollowup)->receiver_id;
            $senderId = optional($firstFollowup)->sender_id;
            $forwardedTo = collect(optional($firstFollowup)->forwards)->pluck('receiver_id')->toArray();
            $endTime = optional($coordination)->end_time;
        }

        return view('livewire.followup-coordination.index', compact(
            'coordinations',
            'followupCoordinations',
            'coordination',
            'firstFollowup',
            'receiverId',
            'senderId',
            'forwardedTo',
            'endTime'
        ));
    }
}
