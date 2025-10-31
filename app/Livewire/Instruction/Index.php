<?php

namespace App\Livewire\Instruction;

use Livewire\Component;
use App\Enums\MessageType;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Services\Instruction\InstructionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = "";
    #[Url]
    public string $messageType =  MessageType::All->value;

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
        $messageTypeEnum = MessageType::tryFrom($this->messageType) ?? MessageType::All;

        $instructions = $this->instructionService->getAllInstructions(
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
