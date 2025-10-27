<?php

namespace App\Livewire\Instruction;

use Livewire\Component;
use App\Enums\MessageType;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Services\Instruction\InstructionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = "";
    #[Url]
    public string $messageType = "received";

    protected InstructionServiceInterface $instructionService;

    public function boot(InstructionServiceInterface $instructionService)
    {
        $this->instructionService = $instructionService;
    }

    public function mount()
    {
        $this->messageType = request('messageType', $this->messageType);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $messageTypeEnum = MessageType::tryFrom($this->messageType) ?? MessageType::Received;

        $instructions = $this->instructionService->getAllInstruction(
            $this->search,
            10,
            $messageTypeEnum,
            true // eager load relasi sender, receivers, forwards
        );

        return view('livewire.instruction.index', [
            'instructions' => $instructions,
            'messageType' => $this->messageType,
        ]);
    }
}
