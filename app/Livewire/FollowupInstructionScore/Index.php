<?php

namespace App\Livewire\FollowupInstructionScore;

use Livewire\Component;
use App\Models\Instruction;
use Livewire\WithPagination;
use App\Models\FollowupInstruction;
use Illuminate\Support\Facades\Auth;
use App\Services\Instruction\InstructionServiceInterface;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $switch = "instructionMode";
    public ?int $selectedInstructionId = null;
    public ?int $selectedFollowupId = null;

    protected InstructionServiceInterface $instructionService;
    protected FollowupInstructionServiceInterface $followupInstructionService;

    public function boot(FollowupInstructionServiceInterface $followupInstructionService, InstructionServiceInterface $instructionService)
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

    public function giveScoreToFollowupInstruction($followupId)
    {
        session(['selectedFollowupInstructionId' => $followupId]);
        return redirect()->route('followupinstructionscore.create');
    }

    public function giveScoreToInstruction($instructionId){
        session(['selectedInstructionId' => $instructionId]);
        return redirect()->route('instructionscore.create');
    }

    public function render()
    {

        if ($this->switch === 'instructionMode') {
            $instructions = $this->instructionService->getInstructionsWithFollowupCounts(
                $this->search,
                10
            );
            return view('livewire.followup-instruction-score.index', [
                'instructions' => $instructions,
                'followupInstructions' => collect(),
            ]);
        }

        if ($this->switch === 'followupInstructionScoreMode' && $this->selectedInstructionId) {

            $followupInstructions = FollowupInstruction::with([
                'forwards',
                'sender',
                'receiver',
                'instruction'
            ])
                ->where('instruction_id', $this->selectedInstructionId)
                ->paginate(10);

            if ($followupInstructions->isNotEmpty()) {
                $followupInstructions->load('followupInstructionScore');
            }

            return view('livewire.followup-instruction-score.index', [
                'instructions' => collect(),
                'followupInstructions' => $followupInstructions,
            ]);
        }
    }
}
