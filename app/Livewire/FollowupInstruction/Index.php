<?php

namespace App\Livewire\FollowupInstruction;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Instruction;
use Illuminate\Support\Facades\Auth;
use App\Enums\MessageType;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $switch = 'instructionMode';
    public ?int $selectedInstructionId = null;
    public string $messageType = 'received';

    protected $updatesQueryString = ['search', 'messageType'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showFollowups($instructionId)
    {
        $this->switch = 'followupInstructionMode';
        $this->selectedInstructionId = $instructionId;
        $this->resetPage();
    }

    public function backToInstructions()
    {
        $this->switch = 'instructionMode';
        $this->selectedInstructionId = null;
        $this->resetPage();
    }

    public function render()
    {
        if ($this->switch === 'instructionMode') {
            $instructions = Instruction::withCount('followups')
                ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('livewire.followup-instruction.index', compact('instructions'));
        }

        if ($this->switch === 'followupInstructionMode' && $this->selectedInstructionId) {
            $userId = Auth::id();
            $followupInstructions = \App\Models\FollowupInstruction::with(['forwards', 'sender', 'receiver', 'instruction'])
                ->where('instruction_id', $this->selectedInstructionId)
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->Where('description', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->messageType === 'sent', fn($q) => $q->where('sender_id', Auth::id()))
                ->when($this->messageType === 'received', fn($q) => $q->where('receiver_id', Auth::id()))
                ->paginate(10);
            return view('livewire.followup-instruction.index', compact('followupInstructions'));
        }
    }
}
