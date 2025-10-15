<?php

namespace App\Livewire\FollowupInstructionScore;

use Livewire\Component;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\FollowupInstruction;
use Illuminate\Support\Facades\Auth;

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

    public function giveScore($followupInstructionId)
    {
        session(key: ['selectedFollowupInstructionId' => $followupInstructionId]);
        return redirect()->route('followupinstructionscore.create');
    }

    public function render()
    {
        if ($this->switch === 'instructionMode') {
            $userId = Auth::id();


            $instructions = Instruction::withCount([
                // Hitung total semua follow-up (untuk pembuat instruksi)
                'followups as total_followups_count',

                // Hitung follow-up yang dibuat oleh user yang sedang login
                'followups as user_followups_count' => function ($query) use ($userId) {
                    $query->where('sender_id', $userId);
                },
            ])
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
            $followupInstructions = FollowupInstruction::with([
                'forwards',
                'sender',
                'receiver',
                'instruction',
                'followupInstructionScore'
            ])
                ->where('instruction_id', $this->selectedInstructionId)
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('description', 'like', '%' . $this->search . '%')
                            ->orWhereHas('instruction', function ($sub) {
                                $sub->where('title', 'like', '%' . $this->search . '%');
                            })
                            ->orWhereHas('sender', function ($sub) {
                                $sub->where('name', 'like', '%' . $this->search . '%');
                            });
                    });
                })
                ->where(function ($query) {
                    $query->where('receiver_id', Auth::id())
                        ->orWhere('sender_id', Auth::id());
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('livewire.followup-instruction-score.index', compact('followupInstructions'));
        }
    }
}
