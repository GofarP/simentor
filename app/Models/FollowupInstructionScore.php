<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowupInstructionScore extends Model
{
    protected $fillable=[
        'followup_instruction_id',
        'user_id',
        'score',
        'comment'
    ];

    public function followupInstruction(){
        return $this->belongsTo(FollowupInstruction::class, 'followup_instruction_id');
    }
}
