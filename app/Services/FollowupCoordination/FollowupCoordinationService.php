<?php

namespace App\Services\FollowupCoordination;

use App\Enums\MessageType;
use App\Models\FollowupCoordination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Coordination\CoordinationRepositoryInterface;
use App\Repositories\FollowupCoordination\FollowupCoordinationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class FollowupCoordinationService implements FollowupCoordinationServiceInterface
{
    private FollowupCoordinationRepositoryInterface $followupCoordinationRepository;
    private CoordinationRepositoryInterface $coordinationRepository;

    public function __construct(
        FollowupCoordinationRepositoryInterface $followupCoordinationRepository,
        CoordinationRepositoryInterface $coordinationRepository
    ) {
        $this->followupCoordinationRepository = $followupCoordinationRepository;
        $this->coordinationRepository = $coordinationRepository;
    }

    
    public function getAll(int $coordinationId, ?string $search = null, MessageType $messageType, int $perPage, bool $eager = false)
    {
        $user = Auth::user();

        $query = $this->followupCoordinationRepository->query()
                    ->where('coordination_id', $coordinationId);

        if ($eager) {
            $query->with(['forwards', 'sender', 'receiver', 'coordination']);
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

       
        return $this->followupCoordinationRepository->paginate($query, $perPage);
    }

   
    public function storeFollowupCoordination(array $data)
    {
        $currentUserId = $data['sender_id'];

        $coordination = $this->coordinationRepository->find($data['coordination_id']);
        if (!$coordination) {
            throw new \Exception('Koordinasi tidak ditemukan.');
        }

        $receiverId = null;
        $forward = $coordination->forwards()->where('forwarded_to', $currentUserId)->latest()->first();
        
        if ($forward) {
            $receiverId = $forward->forwarded_by; 
        } else {
            $direct = $coordination->receivers()->where('user_id', $currentUserId)->first();
            if ($direct) {
                $receiverId = $coordination->sender_id;
            }
        }

        if (!$receiverId) {
            throw new \Exception('Tidak dapat menentukan penerima tindak lanjut koordinasi.');
        }

        $data['receiver_id'] = $receiverId;

        return $this->followupCoordinationRepository->storeFollowupCoordination($data);
    }

    
    public function editFollowupCoordination(FollowupCoordination $followupCoordination, array $data)
    {
        if (request()->hasFile('attachment')) {
            if ($followupCoordination->attachment && Storage::disk('public')->exists($followupCoordination->attachment)) {
                Storage::disk('public')->delete($followupCoordination->attachment);
            }
            $data['attachment'] = request()->file('attachment')->store('attachment', 'public');
        }

        return $this->followupCoordinationRepository->editFollowupCoordination($followupCoordination, $data);
    }

    
    public function deleteFollowupCoordination(FollowupCoordination $followupCoordination)
    {
        if ($followupCoordination->attachment && Storage::disk('public')->exists($followupCoordination->attachment)) {
            Storage::disk('public')->delete($followupCoordination->attachment);
        }

        return $this->followupCoordinationRepository->deleteFollowupCoordination($followupCoordination);
    }
}