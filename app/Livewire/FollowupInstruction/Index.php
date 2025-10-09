<?php

namespace App\Livewire\FollowupInstruction;

use Livewire\Component;
use Livewire\WithPagination;
use App\Enums\MessageType;
use App\Models\Instruction;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = "";
    public string $switch = "instructionMode"; // state awal
    public string $messageType = "received"; // untuk followupInstructionMode
    public array $expanded = []; // bisa digunakan untuk expand detail instruction

    public $instructions; // untuk state instructionMode
    public $followupInstructions; // untuk state followupInstructionMode

    protected FollowupInstructionServiceInterface $followupInstructionService;

    public function boot(FollowupInstructionServiceInterface $followupInstructionService)
    {
        $this->followupInstructionService = $followupInstructionService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function switchClick()
    {
        $this->switch = $this->switch === 'instructionMode'
            ? 'followupInstructionMode'
            : 'instructionMode';

        $this->resetPage();
    }

    public function render()
    {
        if ($this->switch === 'instructionMode') {
            // Ambil data instruction beserta jumlah followup
            $this->instructions = Instruction::withCount('followups')
                ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
                ->orderByDesc('created_at')
                ->paginate(10);
        } else {
            // Ambil data followup instruction sesuai messageType
            $messageTypeEnum = MessageType::from($this->messageType);
            $this->followupInstructions = $this->followupInstructionService
                ->getAll($this->search, $messageTypeEnum, 10);
        }

        return view('livewire.followup-instruction.index', [
            'instructions' => $this->instructions ?? null,
            'followupInstructions' => $this->followupInstructions ?? null,
        ]);
    }
}
