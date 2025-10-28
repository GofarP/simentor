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

    public function giveScore($followupId)
    {
        // simpan followup id ke session agar bisa diakses di halaman form
        session(['selectedFollowupInstructionId' => $followupId]);
        return redirect()->route('followupinstructionscore.create');
    }

    public function render()
    {
        $userId = Auth::id();

        // MODE INSTRUCTION LIST
        if ($this->switch === 'instructionMode') {
            $instructions = $this->instructionService->getInstructionsWithFollowupCounts(
                $this->search,
                10
            );
            return view('livewire.followup-instruction-score.index', [
                'instructions' => $instructions,
                'followupInstructions' => collect(), // untuk mencegah error view
            ]);
        }

        // MODE FOLLOWUP SCORE
    if ($this->switch === 'followupInstructionScoreMode' && $this->selectedInstructionId) {
    $userId = Auth::id();

    // 1. Ambil data UTAMA tanpa relasi score dulu
    $followupInstructions = FollowupInstruction::with([
        'forwards', 'sender', 'receiver', 'instruction'
        // Hapus 'followupInstructionScore' dari with() awal
    ])
        ->where('instruction_id', $this->selectedInstructionId)
        // ... (sisa query when(), where(), orderBy()) ...
        ->paginate(10);

    // 2. SETELAH data utama diambil, PAKSA muat ulang relasi score
    if ($followupInstructions->isNotEmpty()) {
         $followupInstructions->load('followupInstructionScore'); // <-- BARIS KUNCI
    }

    // 3. Kirim ke view
    return view('livewire.followup-instruction-score.index', [
        'instructions' => collect(),
        'followupInstructions' => $followupInstructions,
    ]);
}
    }
}
