<?php

namespace App\Livewire\FollowupInstruction;

use Livewire\Component;
use App\Enums\MessageType;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\FollowupInstruction;
use Illuminate\Support\Facades\Auth;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $switch = 'instructionMode';
    public ?int $selectedInstructionId = null;
    public string $messageType = 'received';


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

        // === MODE INSTRUCTION ===
        if ($this->switch === 'instructionMode') {
            $instructions = Instruction::withCount([
                'followups as user_followups_count' => function ($query) use ($userId) {
                    $query->where(function ($sub) use ($userId) {
                        $sub
                            ->whereHas('instruction.instructionUsers', function ($q) use ($userId) {
                                $q->where('sender_id', $userId);
                            })
                            ->orWhereRaw('followup_instructions.sender_id = ?', [$userId]);
                    });
                },

                'followups as total_followups_count',
            ])
                ->when($this->search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->where(function ($query) use ($userId) {
                    $query
                        ->whereHas('instructionUsers', function ($q) use ($userId) {
                            $q->where('sender_id', $userId)
                                ->orWhere('receiver_id', $userId);
                        })

                        ->orWhereHas('followups', function ($q) use ($userId) {
                            $q->where('receiver_id', $userId);
                        })

                        ->orWhereHas('followups.forwards', function ($q) use ($userId) {
                            $q->where('forwarded_to', $userId);
                        })

                        ->orWhereHas('forwards', function ($q) use ($userId) {
                            $q->where('forwarded_to', $userId);
                        });
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('livewire.followup-instruction.index', compact('instructions'));
        }

        // === MODE FOLLOW-UP ===
        if ($this->switch === 'followupInstructionMode' && $this->selectedInstructionId) {
            $followupInstructions = FollowupInstruction::with(['forwards', 'sender', 'receiver', 'instruction'])
                ->where('instruction_id', $this->selectedInstructionId)
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

            $instructionEndTime = Instruction::where('id', $this->selectedInstructionId)->value('end_time');

            return view('livewire.followup-instruction.index', compact('followupInstructions', 'instructionEndTime'));
        }
    }
}
