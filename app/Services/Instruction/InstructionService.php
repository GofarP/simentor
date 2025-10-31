<?php
namespace App\Services\Instruction;

use App\Enums\MessageType;
use App\Models\Instruction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Instruction\InstructionRepositoryInterface;

class InstructionService implements InstructionServiceInterface
{
    protected $instructionRepository;

    public function __construct(InstructionRepositoryInterface $instructionRepository)
    {
        $this->instructionRepository = $instructionRepository;
    }


    public function getAllInstructions(?string $search = '', int $perPage = 10, MessageType $messageType, bool $eager = false): LengthAwarePaginator
    {
        $userId = Auth::id();
        $query = $this->instructionRepository->query(); // Mulai query dari repo

        // Terapkan Logika Filter MessageType
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

        if ($eager) {
             $query->with([
                'receivers',
                'senders',
                'forwards.forwarder',
                'forwards.receiver',
            ]);
        }

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
        
        return $this->instructionRepository->paginate($query, $perPage);
    }

   
    public function getInstructionsWithFollowupCounts(?string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        $userId = Auth::id();
        $query = $this->instructionRepository->query(); // Mulai query dari repo

        // Terapkan Logika withCount
        $query->with('instructionScore')->withCount([
            'followups as user_followups_count' => function ($query) use ($userId) {
                $query->where(function ($sub) use ($userId) {
                    $sub
                        ->whereHas('instruction.instructionUsers', function ($q) use ($userId) {
                            $q->where('sender_id', $userId);
                        })
                        ->orWhereRaw('followup_instructions.sender_id = ?', [$userId]);
                });
            },
            'followups as total_followups_count',
        ]);

        $query->when($search, function ($query, $search) {
             $query->where(function ($q) use ($search) {
                 $q->where('title', 'like', "%{$search}%")
                     ->orWhere('description', 'like', "%{$search}%");
             });
        });

        $query->where(function ($query) use ($userId) {
            $query
                ->whereHas('instructionUsers', function ($q) use ($userId) {
                    $q->where('sender_id', $userId)
                        ->orWhere('receiver_id', $userId);
                })
                ->orWhereHas('followups', function ($q) use ($userId) {
                    $q->where('receiver_id', $userId);
                })
                ->orWhereHas('followups.forwards', function ($q) use ($userId) {
                    $q->where('forwarded_to', $userId);
                })
                ->orWhereHas('forwards', function ($q) use ($userId) {
                    $q->where('forwarded_to', $userId);
                });
        });

        return $this->instructionRepository->paginate($query, $perPage);
    }

  
    public function storeInstruction(array $data): Instruction
    {
        return DB::transaction(function () use ($data) {
            // 1. Logika File & Auth (Tugas Service)
            if (request()->hasFile('attachment')) {
                $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
            }
            $receiverIds = $data['receiver_id'] ?? [];
            $senderId = Auth::id();

            // 2. Panggil Repo "Bodoh" untuk create
            $instruction = $this->instructionRepository->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'attachment' => $data['attachment'] ?? null,
            ]);

            // 3. Siapkan data pivot
            $pivotData = [];
            foreach ($receiverIds as $receiverId) {
                $pivotData[$receiverId] = ['sender_id' => $senderId];
            }

            if (!empty($pivotData)) {
                $this->instructionRepository->syncReceivers($instruction, $pivotData);
            }

            return $instruction;
        });
    }

 
    public function updateInstruction(Instruction $instruction, array $data): Instruction
    {
        return DB::transaction(function () use ($instruction, $data) {
            if (request()->hasFile('attachment')) {
                if ($instruction->attachment && Storage::disk('public')->exists($instruction->attachment)) {
                    Storage::disk('public')->delete($instruction->attachment);
                }
                $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
            }
            $receiverIds = $data['receiver_id'] ?? [];
            $senderId = Auth::id();

            $this->instructionRepository->update($instruction, [
                'title' => $data['title'],
                'description' => $data['description'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'attachment' => $data['attachment'] ?? $instruction->attachment,
            ]);

            $pivotData = [];
            foreach ($receiverIds as $receiverId) {
                $pivotData[$receiverId] = ['sender_id' => $senderId];
            }
            
            $this->instructionRepository->syncReceivers($instruction, $pivotData);

            return $instruction;
        });
    }

   
    public function deleteInstruction(Instruction $instruction): bool
    {
        return DB::transaction(function () use ($instruction) {
            if ($instruction->attachment && Storage::disk('public')->exists($instruction->attachment)) {
                Storage::disk('public')->delete($instruction->attachment);
            }

            return $this->instructionRepository->delete($instruction);
        });
    }
}