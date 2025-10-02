<?php

namespace App\Livewire\Coordination;

use Livewire\Component;
use App\Enums\MessageType;
use Livewire\WithPagination;
use App\Services\Coordination\CoordinationServiceInterface;

class Index extends Component
{
    use WithPagination;

    public $search = "";

    public string $messageType = "received";

    protected CoordinationServiceInterface $coordinationService;

    public function boot(CoordinationServiceInterface $coordinationService)
    {
        $this->coordinationService = $coordinationService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $jenisPesanEnum = MessageType::from($this->messageType);
        $coordinations = $this->coordinationService->getAllCoordination($this->search, 10, $jenisPesanEnum);
        return view('livewire.coordination.index', [
            'coordinations' => $coordinations
        ]);
    }


}
