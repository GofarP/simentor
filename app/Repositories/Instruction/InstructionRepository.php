<?php

namespace App\Repositories\Instruction;

use App\Enums\MessageType;
use App\Models\Instruction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructionRepository implements InstructionRepositoryInterface
{

    public function getAll(?string $search = '', int $perPage = 10, MessageType $messageType, bool $eager = false)
    {
        $userId = Auth::id();

        $query = Instruction::with([
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
                    // instruksi yang dikirim user
                    $q->where('sender_id', $userId);
                    break;

                case MessageType::Received:
                    // instruksi yang diterima user langsung / lewat forward
                    $q->where('receiver_id', $userId)
                        ->orWhereHas('forwardedUsers', fn($sub) => $sub->where('users.id', $userId));
                    break;

                case MessageType::All:
                default:
                    // semua instruksi terkait user (sebagai sender, receiver, atau penerima forward)
                    $q->where('sender_id', $userId)
                        ->orWhere('receiver_id', $userId)
                        ->orWhereHas('forwardedUsers', fn($sub) => $sub->where('users.id', $userId));
                    break;
            }
        });

        // filter search
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


    public function storeInstruction(array $data)
    {
        if (request()->hasFile('attachment')) {
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }
        $data['sender_id'] = Auth::user()->id;
        return Instruction::create($data);
    }

    public function editInstruction(Instruction $instruction, array $data)
    {
        if (request()->hasFile('attachment')) {
            if ($instruction->attachment && Storage::disk('public')->exists($instruction->attachment)) {
                Storage::disk('public')->delete($instruction->attachment);
            }
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        $instruction->update($data);

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
        return Instruction::where('id',$instructionId)->value('sender_id');
    }

}
