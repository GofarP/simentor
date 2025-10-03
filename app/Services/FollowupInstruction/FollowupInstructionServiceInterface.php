<?php
namespace App\Services\FollowupInstruction;

use App\Models\FollowupInstruction;

interface FollowupInstructionServiceInterface{
    public function getAll(? string $search=null, int $perPage, bool $eager=false);

    public function
}