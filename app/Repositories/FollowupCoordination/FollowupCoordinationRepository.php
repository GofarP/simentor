<?php

namespace App\Repositories\FollowupCoordination;

use App\Enums\MessageType;
use App\Models\FollowupCoordination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FollowupCoordinationRepository implements FollowupCoordinationRepositoryInterface
{
    public function getAll(?string $search = null, int $perPage = 10, MessageType $messageType, bool $eager = false)
    {
        $userId = Auth::id();
        $query = FollowupCoordination::with([
            'sender',
            'receiver',
            'forwardedUsers' => function ($q) {
                $q->withPivot('forwarded_by')->withTimestamps();
            },
            'forwards.forwarder',
            'forwards.receiver'
        ])->where(function ($q) use ($userId, $messageType) {
            switch ($messageType) {
                case MessageType::Sent:
                    $q->where('sender_id', $userId);
                    break;
                case MessageType::Received:
                    $q->where('receiver_id', $userId)
                        ->orWhereHas('forwardedUsers', fn($sub) => $sub->where('users.id', $userId));
                    break;
                case MessageType::All:
                default:
                    $q->where('sender_id', $userId)
                        ->orWhere('receiver_id', $userId)
                        ->orWhereHas('forwardedUsers', fn($sub) => $sub->where('users.id', $userId));
                    break;
            }
        });

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('sender', fn($sub) => $sub->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('receiver', fn($sub) => $sub->where('name', 'like', "%{$search}%"))
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $query->orderByDesc('created_at');

        return $eager
            ? $query->get()
            : $query->paginate($perPage)->onEachSide(1);
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
