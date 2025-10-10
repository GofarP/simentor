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

    protected $updatesQueryString = ['search', 'messageType'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showFollowups($instructionId)
    {
        $this->switch = 'followupInstructionMode';
        $this->selectedInstructionId = $instructionId;
        $this->search="";
        $this->resetPage();
    }

    public function backToInstructions()
    {
        $this->switch = 'instructionMode';
        $this->selectedInstructionId = null;
        $this->resetPage();
    }


    public function goToCreate(){
        session(['selectedInstructionId'=>$this->selectedInstructionId]);

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

            return view('livewire.followup-instruction.index', compact('instructions'));
        }

        if ($this->switch === 'followupInstructionMode' && $this->selectedInstructionId) {
            $userId = Auth::id();
            $followupInstructions = FollowupInstruction::with(['forwards', 'sender', 'receiver', 'instruction'])
                ->where('instruction_id', $this->selectedInstructionId)
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->Where('description', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->messageType === 'sent', fn($q) => $q->where('sender_id', Auth::id()))
                ->when($this->messageType === 'received', fn($q) => $q->where('receiver_id', Auth::id()))
                ->orderByDesc('created_at')
                ->paginate(10);
            return view('livewire.followup-instruction.index', compact('followupInstructions'));
        }
    }
}
