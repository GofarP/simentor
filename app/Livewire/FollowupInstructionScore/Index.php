<?php

namespace App\Livewire\FollowupInstructionScore;

use Livewire\Component;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\FollowupInstruction;
use Illuminate\Support\Facades\Auth;
use App\Models\FollowupInstructionScore;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $switch = "instructionMode";
    public ?int $selectedInstructionId = null;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showFollowups($instructionId)
    {
        $this->switch = 'followupInstructionScoreMode';
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
        if ($this->switch === 'instructionMode') {
            $userId = Auth::id();

            $instructions = Instruction::withCount('followups')
                ->where(function ($query) use ($userId) {
                    $query
                        ->where('sender_id', $userId) // pembuat instruksi
                        ->orWhere('receiver_id', $userId) // penerima langsung
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

            return view('livewire.followup-instruction-score.index', compact('instructions'));
        }

        if ($this->switch === 'followupInstructionScoreMode' && $this->selectedInstructionId) {
            $userId = Auth::id();
            $followupInstructionScores = FollowupInstructionScore::with([
                'followupInstruction.instruction',
                'followupInstruction.sender',
            ])
                ->where('instruction_id', $this->selectedInstructionId)
                ->when($this->search, function ($query) {
                    $query->whereHas('followupInstruction.instruction', function ($q) {
                        $q->where('title', 'like', '%' . $this->search . '%')
                            ->orWhere('description', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('livewire.followup-instruction-score.index', compact('followupInstructionScores'));
        }
    }
}
