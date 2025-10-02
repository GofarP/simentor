<?php
namespace App\Services\Coordination;
use App\Enums\MessageType;
use App\Models\Coordination;
use App\Repositories\Coordination\CoordinationRepositoryInterface;

class CoordinationService implements CoordinationServiceInterface
{
    protected CoordinationRepositoryInterface $coordinationRepository;

    public function __construct(CoordinationRepositoryInterface $coordinationRepository)
    {
        $this->coordinationRepository = $coordinationRepository;
    }

    public function getAllCoordination($search = null, int $perPage = 10, MessageType $messageType, bool $eager = false)
    {
        return $this->coordinationRepository->getAll($search, $perPage, $messageType, $eager);
    }

    public function storeCoordination(array $data): Coordination
    {
        return $this->coordinationRepository->storeCoordination($data);
    }

    public function editCoordination(Coordination $coordination, array $data): Coordination
    {
        return $this->coordinationRepository->editCoordination($coordination, $data);
    }

    public function deleteCoordination(Coordination $coordination): bool
    {
        return $this->coordinationRepository->deleteCoordination($coordination);
    }


    public function forwardCoordination(Coordination $coordination, array $data)
    {
        return $this->coordinationRepository->forwarCoordination($coordination, $data);
    }

}