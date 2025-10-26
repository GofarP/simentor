<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Instruction;
use App\Models\InstructionUser;
use Illuminate\Auth\Access\Response;

class InstructionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Instruction $instruction): bool
    {
        $isUserInInstruction = $instruction->instructionUsers()
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->exists();

        $isUserForwarded = $instruction->forwards()
            ->where('forwarded_to', $user->id)
            ->exists();

        return $isUserInInstruction || $isUserForwarded;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }




    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Instruction $instruction): bool
    {
        return $instruction->instructionUsers()->where('sender_id', $user->id)->exists();
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Instruction $instruction): bool
    {
        return $instruction->instructionUsers()->where('sender_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Instruction $instruksi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Instruction $instruksi): bool
    {
        return false;
    }

    public function forward(User $user, Instruction $instruction): bool
    {
        $isReceiver = $instruction->instructionUsers()
            ->where('receiver_id', $user->id)
            ->exists();

        return $isReceiver && $user->hasRole('kasubbag');
    }
}
