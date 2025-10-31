<?php

namespace App\Services\FollowupInstruction; // Sesuaikan namespace Anda

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Instruction\InstructionRepositoryInterface; 
use App\Repositories\FollowupInstruction\FollowupInstructionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class FollowupInstructionService implements FollowupInstructionServiceInterface
{
    private FollowupInstructionRepositoryInterface $followupInstructionRepository;
    private InstructionRepositoryInterface $instructionRepository; 

    public function __construct(
        FollowupInstructionRepositoryInterface $followupInstructionRepository,
        InstructionRepositoryInterface $instructionRepository 
    ) {
        $this->followupInstructionRepository = $followupInstructionRepository;
        $this->instructionRepository = $instructionRepository;
    }

    
    public function getAll(?int $instructionId, ?string $search = null, MessageType $messageType, int $perPage, bool $eager = false): LengthAwarePaginator
    {
        $user = Auth::user();

        $query = $this->followupInstructionRepository->query()
                    ->where('instruction_id', $instructionId);

        if ($eager) {
            $query->with(['forwards', 'sender', 'receiver', 'instruction']);
        }

        $query->when($search, function ($query, $search) {
            $query->where('description', 'like', '%' . $search . '%');
        });

        if ($messageType === MessageType::Sent) {
            $query->where('sender_id', $user->id);
        } elseif ($messageType === MessageType::Received) {
            $query->where(function ($sub) use ($user) {
                $sub->where('receiver_id', $user->id)
                    ->orWhereHas('forwards', function ($q2) use ($user) {
                        $q2->where('forwarded_to', $user->id);
                    });
            });
        } elseif ($messageType === MessageType::All) {
            $isKasubbagOrKasek = $user->hasAnyRole(['kasubbag', 'kasek']);
            if (!$isKasubbagOrKasek) {
                $query->where(function ($sub) use ($user) {
                    $sub->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id)
                        ->orWhereHas('forwards', function ($q2) use ($user) {
                            $q2->where('forwarded_to', $user->id);
                        });
                });
            }
        
        }

       
        return $this->followupInstructionRepository->paginate($query, $perPage);
    }

   
    public function storeFollowupInstruction(array $data): FollowupInstruction
    {
        $currentUserId = $data['sender_id'];

        $instruction = $this->instructionRepository->getInstructionById($data['instruction_id']); // Ganti 'getInstructionId' jika perlu
        if (!$instruction) {
            throw new \Exception('Instruksi tidak ditemukan.');
        }

        $receiverId = null;
        $forward = $instruction->forwards()->where('forwarded_to', $currentUserId)->latest()->first();
        
        if ($forward) {
            $receiverId = $forward->forwarded_by; 
        } else {
            $direct = $instruction->instructionUsers()->where('receiver_id', $currentUserId)->first();
            if ($direct) {
                $receiverId = $direct->sender_id; 
            }
        }

        if (!$receiverId) {
            throw new \Exception('Tidak dapat menentukan penerima tindak lanjut.');
        }

        $data['receiver_id'] = $receiverId;

        return $this->followupInstructionRepository->storeFollowupInstruction($data);
    }

    
    public function editFollowupInstruction(FollowupInstruction $followupInstruction, array $data): bool
    {
        if (request()->hasFile('attachment')) {
            if ($followupInstruction->attachment && Storage::disk('public')->exists($followupInstruction->attachment)) {
                Storage::disk('public')->delete($followupInstruction->attachment);
            }
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }
        if (request()->hasFile('proof')) {
            if ($followupInstruction->proof && Storage::disk('public')->exists($followupInstruction->proof)) {
                Storage::disk('public')->delete($followupInstruction->proof);
            }
            $data['proof'] = request()->file('proof')->store('proof', 'public');
        }

        return $this->followupInstructionRepository->editFollowupInstruction($followupInstruction, $data);
    }

    
    public function deleteFollowupInstruction(FollowupInstruction $followupInstruction): bool
    {
        if ($followupInstruction->attachment && Storage::disk('public')->exists($followupInstruction->attachment)) {
            Storage::disk('public')->delete($followupInstruction->attachment);
        }
        if ($followupInstruction->proof && Storage::disk('public')->exists($followupInstruction->proof)) {
            Storage::disk('public')->delete($followupInstruction->proof);
        }

        return $this->followupInstructionRepository->deleteFollowupInstruction($followupInstruction);
    }
}