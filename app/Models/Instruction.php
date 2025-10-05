<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Instruction extends Model
{
    protected $fillable = [
        "sender_id",
        "receiver_id",
        "title",
        "description",
        "start_time",
        "end_time",
        "attachment"
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function forwardedUsers()
    {
        return $this->belongsToMany(User::class, 'forward_instructions', 'instruction_id', 'forwarded_to')
            ->withPivot('forwarded_by')
            ->withTimestamps();
    }
    public function forwards()
    {
        return $this->hasMany(ForwardInstruction::class, 'instruction_id');
    }
}

