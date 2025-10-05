<?php

namespace App\Repositories\FollowupInstruction;

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FollowupInstructionRepository implements FollowupInstructionRepositoryInterface
{
    public function getAll(string|null $search = null, int $perPage = 10, MessageType $messageType, bool $eager = false)
    {
        $userId = Auth::id();
        $query = FollowupInstruction::with([
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


    public function storeFollowupInstruction(array $data)
    {
        if (request()->hasFile('attachment')) {
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        if (request()->hasFile('proof')) {
            $data['proof'] = request()->file('proof')->store('proof', 'public');
        }

        $data['sender_id'] = Auth::user()->id;


        return FollowupInstruction::create($data);
    }

    public function editFollowupInstruction(FollowupInstruction $followupInstruction, array $data)
    {
        // Handle attachment
        if (request()->hasFile('attachment')) {
            if ($followupInstruction->attachment && Storage::disk('public')->exists($followupInstruction->attachment)) {
                Storage::disk('public')->delete($followupInstruction->attachment);
            }
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        // Handle proof
        if (request()->hasFile('proof')) {
            if ($followupInstruction->proof && Storage::disk('public')->exists($followupInstruction->proof)) {
                Storage::disk('public')->delete($followupInstruction->proof);
            }
            $data['proof'] = request()->file('proof')->store('proof', 'public');
        }

        // Update data ke database
        $followupInstruction->update($data);

        return $followupInstruction;
    }



    public function deleteFollowupInstruction(FollowupInstruction $followupInstruction): bool
    {
        if ($followupInstruction->attachment && Storage::disk('public')->exists($followupInstruction->attachment)) {
            Storage::disk('public')->delete($followupInstruction->attachment);
        }

        if ($followupInstruction->proof && Storage::disk('public')->exists($followupInstruction->followupInstruction)) {
            Storage::disk('public')->delete($followupInstruction->proof);
        }

        return  $followupInstruction->delete();
    }
}
