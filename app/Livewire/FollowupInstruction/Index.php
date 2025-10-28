<?php

namespace App\Livewire\FollowupInstruction;

use Carbon\Carbon;
use Livewire\Component;
use App\Enums\MessageType;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\FollowupInstruction;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;
use App\Services\Instruction\InstructionServiceInterface;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $switch = 'instructionMode';
    public ?int $selectedInstructionId = null;
    public string $messageType = MessageType::All->value;

    protected InstructionServiceInterface $instructionService;
    protected FollowupInstructionServiceInterface $followupInstructionService;

    public function boot(FollowupInstructionServiceInterface $followupInstructionService,InstructionServiceInterface $instructionService)
    {
        $this->instructionService = $instructionService;
        $this->followupInstructionService = $followupInstructionService;

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showFollowups($instructionId)
    {
        $this->switch = 'followupInstructionMode';
        $this->selectedInstructionId = $instructionId;
        $this->search = "";
        $this->resetPage();
    }

    public function backToInstructions()
    {
        $this->switch = 'instructionMode';
        $this->selectedInstructionId = null;
        $this->resetPage();
    }


    public function goToCreate()
    {
        session(key: ['selectedInstructionId' => $this->selectedInstructionId]);

        return redirect()->route('followupinstruction.create');
    }

    public function render()
    {
        $userId = Auth::id();

        $instructions = null;
        $followupInstructions = null;
        $instruction = null;
        $firstFollowup = null;
        $receiverId = null;
        $senderId = null;
        $forwardedTo = [];
        $endTime = null;

        $messageTypeEnum = MessageType::tryFrom($this->messageType) ?? MessageType::All;

        if ($this->switch === 'instructionMode') {

            $instructions = $this->instructionService->getInstructionsWithFollowupCounts(
                $this->search,
                10
            );
        }

        if ($this->switch === 'followupInstructionMode' && $this->selectedInstructionId) {

            // Panggil Repository Followup
            $followupInstructions = $this->followupInstructionService->getAll(
                $this->selectedInstructionId,
                $this->search,
                $messageTypeEnum,
                10,
                true
            );

            $instruction = Instruction::where('id', $this->selectedInstructionId)->first();
            $firstFollowup = $followupInstructions->first();
            $receiverId = optional($firstFollowup)->receiver_id;
            $senderId = optional($firstFollowup)->sender_id;
            $forwardedTo = collect(optional($firstFollowup)->forwards)->pluck('receiver_id')->toArray();
            $endTime = optional($instruction)->end_time;
        }

        return view('livewire.followup-instruction.index', compact(
            'instructions',
            'followupInstructions',
            'instruction',
            'firstFollowup',
            'receiverId',
            'senderId',
            'forwardedTo',
            'endTime'
        ));
    }
}
