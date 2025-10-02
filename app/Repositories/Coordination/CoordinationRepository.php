<?php
namespace App\Repositories\Coordination;
use App\Enums\MessageType;
use App\Models\Coordination;
use App\Models\ForwardCoordination;
use App\Repositories\Coordination\CoordinationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoordinationRepository implements CoordinationRepositoryInterface
{
    public function getAll(?string $search = null, int $perPage = 10, MessageType $messageType, bool $eager = false)
    {
        $userId = Auth::id();

        $query = Coordination::with(['sender', 'receiver', 'forwards.forwarder', 'forwards.receiver'])
            ->where(function ($q) use ($userId, $messageType) {
                switch ($messageType) {
                    case MessageType::Sent:
                        $q->where('sender_id', $userId);
                        break;

                    case MessageType::Received:
                        $q->where('receiver_id', $userId)
                            ->orWhereHas('forwards', fn($sub) => $sub->where('forwarded_to', $userId));
                        break;

                    case MessageType::All:
                    default:
                        $q->where('sender_id', $userId)
                            ->orWhere('receiver_id', $userId)
                            ->orWhereHas('forwards', fn($sub) => $sub->where('forwarded_to', $userId));
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

        return $eager ? $query->get() : $query->paginate($perPage)->onEachSide(1);
    }

    public function storeCoordination(array $data)
    {
        if (request()->hasFile('attachment')) {
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        $data['sender_id'] = Auth::user()->id;

        return Coordination::create($data);

    }


    public function editCoordination(Coordination $coordination, array $data)
    {
        if (request()->hasFile('attachment')) {
            if ($coordination->attachment && Storage::disk('public')->exists($coordination->attachment)) {
                Storage::disk('public')->delete($coordination->attachment);
            }
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }
    }

    public function deleteCoordination(Coordination $coordination): bool
    {
        if ($coordination->attachment && Storage::disk('public')->exists($coordination->attachment)) {
            Storage::disk('public')->delete($coordination->attachment);
        }

        return $coordination->delete();
    }

    public function forwarCoordination(Coordination $coordination, array $data)
    {
        $forwardedRecords=[];
        foreach($data['forwarded_to'] as $receiverId){
            $forwardedRecords[]=ForwardCoordination::create([
                'instruction_id'=>$coordination->id,
                'forwarded_by'=>Auth::id(),
                'forwarded_to'=>$receiverId,
            ]);
        }

        return $forwardedRecords;
    }
}
