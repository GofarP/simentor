<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructionScore extends Model
{
    protected $fillable = [
        'instruction_id',
        'user_id',
        'score',
        'comment'
    ];

    public function instruction()
    {
        return $this->belongsTo(FollowupInstruction::class, 'followup_instruction_id');
    }
}
