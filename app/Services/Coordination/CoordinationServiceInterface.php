<?php
namespace App\Services\Coordination;

use App\Enums\MessageType;
use App\Models\Coordination;
use Illuminate\Pagination\LengthAwarePaginator;

interface CoordinationServiceInterface
{
    public function getAllCoordinations(?string $search, int $perPage, MessageType $messageType, bool $eager): LengthAwarePaginator;
    public function getCoordinationsWithFollowupCounts(?string $search, int $perPage): LengthAwarePaginator;
    public function storeCoordination(array $data): Coordination;
    public function updateCoordination(Coordination $coordination, array $data): Coordination;
    public function deleteCoordination(Coordination $coordination): bool;
}