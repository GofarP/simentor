<?php
namespace App\Services\Instruction;
use App\Enums\MessageType;
use App\Repositories\Instruction\InstructionRepositoryInterface;
use App\Models\Instruction;

class InstructionService implements InstructionServiceInterface{
    protected InstructionRepositoryInterface $instructionRepository;

    public function __construct(InstructionRepositoryInterface $instructionRepository) {
        $this->instructionRepository=$instructionRepository;
    }


    public function getAllInstruction($search = null, int $perPage = 10, MessageType $messageType ,bool $eager = false){
        return $this->instructionRepository->getAll($search, $perPage,$messageType, $eager);
    }

    public function storeInstruction(array $data): Instruction
    {
        return $this->instructionRepository->storeInstruction($data);
    }

    public function editInstruction(Instruction $instruction, array $data): Instruction
    {
        return $this->instructionRepository->editInstruction($instruction, $data);
    }

    public function deleteInstruction(Instruction $instruction): bool
    {
        return $this->instructionRepository->deleteInstruction($instruction);
    }

    public function forwardInstruction(Instruction $instruction, array $data){
        return $this->instructionRepository->forwardInstruction($instruction, $data);
    }

}
