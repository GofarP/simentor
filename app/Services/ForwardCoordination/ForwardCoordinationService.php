<?php

namespace App\Services\ForwardCoordination;

use App\Models\Coordination;
use App\Models\Instruction;
use App\Repositories\ForwardCoordination\ForwardCoordinationRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ForwardCoordinationService implements ForwardCoordinationServiceInterface
{
    protected $forwardCoordinationRepository;

    public function __construct(ForwardCoordinationRepositoryInterface $forwardCoordinationRepository)
    {
        $this->forwardCoordinationRepository = $forwardCoordinationRepository;
    }
    public function forwardCoordination(Coordination $coordination, array $data)
    {
        $forwardedTo = $data['forwarded_to'] ?? [];
        $pivotData = collect($forwardedTo)->mapWithKeys(function ($receiverId) {
            return [$receiverId => ['forwarded_by' => Auth::id()]];
        })->toArray();

        $this->forwardCoordinationRepository->syncForwardedUsers($coordination, $pivotData);
        return $coordination->load('forwardedUsers');
    }

    public function deleteForwardCoordination(Coordination $coordination): bool
    {
        return $this->forwardCoordinationRepository->deleteByCoordinationId($coordination->id);
    }

    public function getForwardCoordination(Coordination $coordination)
    {
        return $this->forwardCoordinationRepository->getQueryByCoordinationId($coordination->id);
    }
}
