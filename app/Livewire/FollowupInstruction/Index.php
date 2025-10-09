<?php

namespace App\Livewire\FollowupInstruction;

use Livewire\Component;
use App\Enums\MessageType;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = "";
    public $messageType = "received";

    public array $expanded = [];

    protected FollowupInstructionServiceInterface $followupInstructionService;

    public function boot(FollowupInstructionServiceInterface $followupInstructionService)
    {
        $this->followupInstructionService = $followupInstructionService;
        $this->instructions = collect();
        $this->followupInstructions = collect();
    }

    public function updatingSearch()
    {
        // Update sesuai mode
        if ($this->switch === 'instructionMode') {
            $this->mountInstructions();
        } elseif ($this->switch === 'followupInstructionMode' && $this->selectedInstructionId) {
            $this->showFollowups($this->selectedInstructionId);
        }
    }

    public function toggleFollowups(int $instructionId)
    {
        if (in_array($instructionId, $this->expanded)) {
            $this->expanded = array_diff($this->expanded, [$instructionId]);
        }else{
            $this->expanded[] = $instructionId;
        }
    }

    public function render()
    {
        $messageTypeEnum = MessageType::from($this->messageType);
        $followupInstruction = $this->followupInstructionService->getAll($this->search, $messageTypeEnum, 10);
        return view('livewire.followup-instruction.index', [
            'followupInstructions' => $followupInstruction
        ]);
    }
}
