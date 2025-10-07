<?php

namespace App\Livewire\InstructionScore;

use App\Services\Instruction\InstructionService;
use App\Services\Instruction\InstructionServiceInterface;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\InstructionScore\InstructionScoreServiceInterface;
class Index extends Component
{
    use WithPagination;

    public string $search="";


    protected InstructionScoreServiceInterface $instructionScoreService;

    public function boot(InstructionScoreServiceInterface $instructionScoreService){
        $this->instructionScoreService=$instructionScoreService;
    }


    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $instructionScores=$this->instructionScoreService->getAllInstructionScore($this->search, 10);
        return view('livewire.instruction-score.index',[
            'instructionScores'=>$instructionScores
        ]);
    }
}
