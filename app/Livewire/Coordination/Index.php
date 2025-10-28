<?php

namespace App\Livewire\Coordination;

use Livewire\Component;
use App\Enums\MessageType;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Services\Coordination\CoordinationServiceInterface;

class Index extends Component
{
    use WithPagination;

    public $search = "";

    #[Url]
    public string $messageType = MessageType::All->value;

    protected CoordinationServiceInterface $coordinationService;

    public function boot(CoordinationServiceInterface $coordinationService)
    {
        $this->coordinationService = $coordinationService;
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
        $messageTypeEnum = MessageType::tryFrom($this->messageType) ?? MessageType::All;

        $coordinations = $this->coordinationService->getAllCoordination(
            $this->search,
            10,
            $messageTypeEnum, true
        );

        return view('livewire.coordination.index', [
            'coordinations' => $coordinations,
            'messageType' => $this->messageType,
        ]);
    }
}
