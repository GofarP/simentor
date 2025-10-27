<?php

namespace App\Repositories\FollowupInstruction;

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FollowupInstructionRepository implements FollowupInstructionRepositoryInterface
{
    public function getAll(?int $instructionId, string|null $search = null, int $perPage = 10, MessageType $messageType, bool $eager = false)
    {
        $userId = Auth::id();

        $query = FollowupInstruction::query()
            ->where('instruction_id', $instructionId);

        if ($eager) {
            $query->with(['forwards', 'sender', 'receiver', 'instruction']);
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
