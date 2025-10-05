<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowupInstruction extends Model
{
    protected $fillable = [
        "instruction_id",
        "sender_id",
        "receiver_id",
        "proof",
        "attachment",
        "description"
    ];

    public function instruction()
    {
        return $this->hasMany(Instruction::class, 'instruction_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function forwardedUsers()
    {
        return $this->belongsToMany(User::class, 'forward_instructions', 'instruction_id', 'forwarded_to')
            ->withPivot('forwarded_by')
            ->withTimestamps();
    }

    public function forward()
    {
        return $this->hasMany(ForwardInstruction::class, 'instruction_id');
    }
}
