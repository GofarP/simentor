<?php

namespace App\Repositories\FollowupCoordination;

use App\Enums\MessageType;
use App\Models\FollowupCoordination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FollowupCoordinationRepository implements FollowupCoordinationRepositoryInterface
{
    public function getAll(int $coordinationId, ?string $search = null, int $perPage = 10, MessageType $messageType, bool $eager = false)
    {
        $userId = Auth::id();

        $query = FollowupCoordination::query()
            ->where('coordination_id', $coordinationId);

        if ($eager) {
            $query->with(['forwards', 'sender', 'receiver', 'coordination']);
        }

        $query->when($search, function ($query, $search) {
            $query->where('description', 'like', '%' . $search . '%');
        });

        if ($messageType === MessageType::Sent) {
            $query->where('sender_id', $userId);
        } elseif ($messageType === MessageType::Received) {
            $query->where(function ($sub) use ($userId) {
                $sub->where('receiver_id', $userId)
                    ->orWhereHas('forwards', function ($q2) use ($userId) {
                        $q2->where('forwarded_to', $userId);
                    });
            });
        }

        return $query->orderByDesc('created_at')
            ->paginate($perPage)
            ->onEachSide(1);
    }

    public function storeFollowupCoordination(array $data)
    {
        if (request()->hasFile('attachment')) {
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        $data['sender_id'] = Auth::user()->id;

        return FollowupCoordination::create($data);
    }

    public function editFollowupCoordination(FollowupCoordination $followupCoordination, array $data)
    {
        // Handle attachment
        if (request()->hasFile('attachment')) {
            if ($followupCoordination->attachment && Storage::disk('public')->exists($followupCoordination->attachment)) {
                Storage::disk('public')->delete($followupCoordination->attachment);
            }
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        // Update data ke database
        $followupCoordination->update($data);

        return $followupCoordination;
    }

    public function deleteFollowupCoordination(FollowupCoordination $followupCoordination): bool
    {
        if ($followupCoordination->attachment && Storage::disk('public')->exists($followupCoordination->attachment)) {
            Storage::disk('public')->delete($followupCoordination->attachment);
        }

        return  $followupCoordination->delete();
    }
}
