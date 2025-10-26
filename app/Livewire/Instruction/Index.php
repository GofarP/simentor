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

    protected InstructionServiceInterface $instruksiService;

    public function boot(InstructionServiceInterface $instruksiService)
    {
        $this->instruksiService = $instruksiService;
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
        // Konversi ke enum
        $messageTypeEnum = MessageType::tryFrom($this->messageType) ?? MessageType::Received;

        // Ambil instruksi dari service, pivot sudah menampung sender & receiver
        $instructions = $this->instruksiService->getAllInstruction(
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
