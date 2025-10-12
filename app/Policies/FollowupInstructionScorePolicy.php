<?php

namespace App\Policies;

use App\Models\FollowupInstructionScore;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FollowupInstructionScorePolicy
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
    public function view(User $user, FollowupInstructionScore $followupInstructionScore): bool
    {
        return $user->id===$followupInstructionScore->user_id
        || $user->id=== $followupInstructionScore->followupInstruction->sender_id;
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
    public function update(User $user, FollowupInstructionScore $followupInstructionScore): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FollowupInstructionScore $followupInstructionScore): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FollowupInstructionScore $followupInstructionScore): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FollowupInstructionScore $followupInstructionScore): bool
    {
        return false;
    }
}
