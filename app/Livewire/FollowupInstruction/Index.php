<?php

namespace App\Livewire\FollowupInstruction;

use Livewire\Component;
use App\Enums\MessageType;
use App\Models\Instruction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;

class Index extends Component
{
    public string $search = '';
    public string $switch = 'instructionMode'; // 'instructionMode' atau 'followupInstructionMode'
    public int|null $selectedInstructionId = null;
    public string $messageType = 'received'; // digunakan di followup mode: sent, received, all

    public Collection $instructions;          // semua instruction user
    public Collection $followupInstructions;  // followup instruction per instruction

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

    // Mode detail followup
    public function showFollowups(int $instructionId)
    {
        $this->switch = 'followupInstructionMode';
        $this->selectedInstructionId = $instructionId;

        $messageTypeEnum = MessageType::from($this->messageType);
        $userId = Auth::id();

        // Ambil semua followup instruction
        $allFollowups = collect($this->followupInstructionService->getAll($this->search, $messageTypeEnum, 100));

        // Filter berdasarkan instruction_id dan messageType
        $this->followupInstructions = $allFollowups->filter(function ($f) use ($instructionId, $messageTypeEnum, $userId) {
            if (data_get($f, 'instruction_id') != $instructionId) return false;

            return match ($messageTypeEnum) {
                MessageType::Sent => data_get($f, 'sender_id') == $userId,
                MessageType::Received => data_get($f, 'receiver_id') == $userId,
                MessageType::All => true,
            };
        })->values();
    }

    // Tombol kembali ke daftar instruction
    public function backToInstructions()
    {
        $this->switch = 'instructionMode';
        $this->selectedInstructionId = null;
        $this->mountInstructions();
    }

    // Mount daftar instruction sesuai user
    public function mountInstructions()
    {
        $userId = Auth::id();

        $this->instructions = Instruction::withCount('followups')
            ->where('sender_id', $userId) // instruction yang dibuat user
            ->orWhereHas('followups', fn($q) => $q->where('sender_id', $userId)) // instruction yang user sudah followup
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        if ($this->switch === 'instructionMode') {
            $this->mountInstructions();
        }

        return view('livewire.followup-instruction.index');
    }
}
