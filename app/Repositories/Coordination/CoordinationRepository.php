<?php

namespace App\Repositories\Coordination;

use App\Enums\MessageType;
use App\Models\Coordination;
use App\Models\CoordinationUser;
use App\Models\ForwardCoordination;
use App\Repositories\Coordination\CoordinationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoordinationRepository implements CoordinationRepositoryInterface
{
    public function getAll(?string $search = '', int $perPage = 10, MessageType $messageType, bool $eager = false)
    {
        $userId = Auth::id();

        $query = Coordination::query();

        // Filter sesuai MessageType
        $query->where(function ($q) use ($userId, $messageType) {
            $q->whereHas('coordinationUsers', function ($q2) use ($userId, $messageType) {
                switch ($messageType) {
                    case MessageType::Sent:
                        $q2->where('sender_id', $userId);
                        break;

                    case MessageType::Received:
                        $q2->where('receiver_id', $userId);
                        break;

                    case MessageType::All:
                    default:
                        $q2->where(function ($q3) use ($userId) {
                            $q3->where('sender_id', $userId)
                                ->orWhere('receiver_id', $userId);
                        });
                        break;
                }
            });

            // Tambahkan filter forwarded
            $q->orWhereHas('forwards', function ($qf) use ($userId, $messageType) {
                if ($messageType === MessageType::Sent) {
                    $qf->where('forwarded_by', $userId);
                } elseif ($messageType === MessageType::Received) {
                    $qf->where('forwarded_to', $userId);
                } else {
                    $qf->where('forwarded_by', $userId)
                        ->orWhere('forwarded_to', $userId);
                }
            });
        });

        // Eager load relasi jika diminta
        if ($eager) {
            $query->with([
                'receivers',
                'senders',
                'forwards.forwarder',
                'forwards.receiver',
            ]);
        }

        // Filter search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('senders', fn($sub) => $sub->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('receivers', fn($sub) => $sub->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('forwards.forwarder', fn($sub) => $sub->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('forwards.receiver', fn($sub) => $sub->where('name', 'like', "%{$search}%"));
            });
        }

        return $query->orderByDesc('created_at')
            ->paginate($perPage)
            ->onEachSide(1);
    }

    public function storeCoordination(array $data)
    {
        // Simpan lampiran jika ada
        if (request()->hasFile('attachment')) {
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        // Ambil list penerima dari form
        $receiverIds = $data['receiver_id'] ?? [];
        unset($data['receiver_id']); // hapus dari data utama karena tidak ada di tabel utama

        // Simpan instruksi utama
        $coordination = Coordination::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'attachment' => $data['attachment'] ?? null,
        ]);

        $senderId = Auth::id();

        // Simpan ke pivot via Eloquent
        $pivotData = [];
        foreach ($receiverIds as $receiverId) {
            $pivotData[$receiverId] = ['sender_id' => $senderId];
        }

        if (!empty($pivotData)) {
            $coordination->receivers()->sync($pivotData);
        }

        return $coordination;
    }


    public function editCoordination(Coordination $coordination, array $data)
    {
        if (request()->hasFile('attachment')) {
            if ($coordination->attachment && Storage::disk('public')->exists($coordination->attachment)) {
                Storage::disk('public')->delete($coordination->attachment);
            }
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        // Update data utama
        $coordination->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'attachment' => $data['attachment'] ?? $coordination->attachment,
        ]);

        // Update pivot (receiver)
        $receiverIds = $data['receiver_id'] ?? [];
        $senderId = Auth::id();

        // Detach existing receivers for the current sender
        $coordination->receivers()->wherePivot('sender_id', $senderId)->detach();

        // Attach new receivers for the current sender
        foreach ($receiverIds as $receiverId) { // Assuming $receiverIds is an array of user IDs
            $coordination->receivers()->attach($receiverId, ['sender_id' => $senderId]);
        }

        return $coordination;
    }

    public function deleteCoordination(Coordination $coordination): bool
    {
        if ($coordination->attachment && Storage::disk('public')->exists($coordination->attachment)) {
            Storage::disk('public')->delete($coordination->attachment);
        }

        return $coordination->delete();
    }

    public function getSenderIdByCoordination(int $id): int
    {
        return CoordinationUser::where('coordination_id', $id)->value('sender_id');
    }
}
