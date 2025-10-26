<?php

namespace App\Repositories\Instruction;

use App\Enums\MessageType;
use App\Models\Instruction;
use App\Models\InstructionUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructionRepository implements InstructionRepositoryInterface
{

    public function getAll(?string $search = '', int $perPage = 10, MessageType $messageType, bool $eager = false)
    {
        $userId = Auth::id();

        $query = Instruction::query();

        // Filter sesuai MessageType
        $query->where(function ($q) use ($userId, $messageType) {
            $q->whereHas('instructionUsers', function ($q2) use ($userId, $messageType) {
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



    public function storeInstruction(array $data)
    {
        // Simpan lampiran jika ada
        if (request()->hasFile('attachment')) {
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        // Ambil list penerima dari form
        $receiverIds = $data['receiver_id'] ?? [];
        unset($data['receiver_id']); // hapus dari data utama karena tidak ada di tabel utama

        // Simpan instruksi utama
        $instruction = Instruction::create([
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
            $instruction->receivers()->sync($pivotData);
        }

        return $instruction;
    }




    public function editInstruction(Instruction $instruction, array $data)
    {
        if (request()->hasFile('attachment')) {
            if ($instruction->attachment && Storage::disk('public')->exists($instruction->attachment)) {
                Storage::disk('public')->delete($instruction->attachment);
            }
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        // Update data utama
        $instruction->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'attachment' => $data['attachment'] ?? $instruction->attachment,
        ]);

        // Update pivot (receiver)
        $receiverIds = $data['receiver_id'] ?? [];
        $senderId = Auth::id();

        // Detach existing receivers for the current sender
        $instruction->receivers()->wherePivot('sender_id', $senderId)->detach();

        // Attach new receivers for the current sender
        foreach ($receiverIds as $receiverId) { // Assuming $receiverIds is an array of user IDs
            $instruction->receivers()->attach($receiverId, ['sender_id' => $senderId]);
        }

        return $instruction;
    }


    public function deleteInstruction(Instruction $instruction): bool
    {
        if ($instruction->attachment && Storage::disk('public')->exists($instruction->attachment)) {
            Storage::disk('public')->delete($instruction->attachment);
        }

        return $instruction->delete();
    }

    public function getSenderIdByInstruction(int $instructionId): ?int
    {
        return InstructionUser::where('instruction_id', $instructionId)
            ->value('sender_id');
    }
}
