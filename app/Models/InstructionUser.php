<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructionUser extends Model
{


    protected $fillable = [
        "instruction_id",
        "sender_id",
        "receiver_id"
    ];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class, 'instruction_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }


}
