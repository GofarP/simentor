<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForwardFollowupInstruction extends Model
{
    protected $fillable=[
        "followup_instruction_id",
        "forwarded_by",
        "forwarded_to"
    ];

    public function followupInstruction(){
        return $this->belongsTo(FollowupInstruction::class,'followup_instruction_id');
    }

    public function forwarder(){
        return $this->belongsTo(User::class,'forwarded_by');
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'forwarded_to');
    }

    



}
