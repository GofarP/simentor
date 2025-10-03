<?php
namespace App\Repositories\FollowupInstruction;

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use Illuminate\Support\Facades\Auth;

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

        

    }


    public function storeFollowupInstruction(array $data)
    {

    }

    public function editFollowupInstruction(array $data)
    {

    }


    public function deleteFollowupInstruction(array $data): bool
    {
        return false;
    }
}
