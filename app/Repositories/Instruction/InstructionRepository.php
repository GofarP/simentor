<?php

namespace App\Repositories\Instruction;

use App\Enums\InstructionType;
use App\Models\ForwardInstruction;
use App\Models\Instruction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructionRepository implements InstructionRepositoryInterface
{
    public function getAll(?string $search = '', int $perPage = 10, InstructionType $instructionType, bool $eager = false)
    {
        $query = Instruction::with([
            'sender',
            'receiver',
            'forwards', 
        ]);

        if ($instructionType == InstructionType::All) {
            $query->where(function ($q) {
                $q->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            });
        }

        if ($instructionType == InstructionType::Sent) {
            $query->where('sender_id', Auth::id());
        }

        if ($instructionType == InstructionType::Received) {
            $query->where('receiver_id', Auth::id());
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->orWhereHas('sender', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('receiver', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
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

    public function forwardInstruction(Instruction $instruction, array $data)
    {
        $forwardedRecords = [];

        foreach ($data['forwarded_to'] as $receiverId) {
            $forwardedRecords[] = ForwardInstruction::create([
                'instruction_id' => $instruction->id,
                'forwarded_by' => Auth::id(),
                'forwarded_to' => $receiverId,
            ]);
        }

        return $forwardedRecords;

    }


}
