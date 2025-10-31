<?php

namespace App\Services\ForwardInstruction;

use App\Models\Instruction;
use App\Repositories\ForwardInstruction\ForwardInstructionRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ForwardInstructionService implements ForwardInstructionServiceInterface
{
    protected $forwardInstructionRepository;

    public function __construct(ForwardInstructionRepositoryInterface $forwardInstructionRepository)
    {
        $this->forwardInstructionRepository = $forwardInstructionRepository;
    }


    public function forwardInstruction(Instruction $instruction, array $data)
    {
        $forwardedTo = $data['forwarded_to'] ?? [];

        $pivotData = collect($forwardedTo)->mapWithKeys(function ($receiverId) {
            return [$receiverId => ['forwarded_by' => Auth::id()]];
        })->toArray();

        $this->forwardInstructionRepository->syncForwardedUsers($instruction, $pivotData);

        return $instruction->load('forwardedUsers');
    }
    public function deleteForwardInstruction(Instruction $instruction): bool
    {
        return $this->forwardInstructionRepository->deleteByInstructionId($instruction->id);
    }

    public function getForwardInstruction(Instruction $instruction)
    {
        return $this->forwardInstructionRepository->getQueryByInstructionId($instruction->id);
    }
}
