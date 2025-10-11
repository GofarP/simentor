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

    // Relasi ke instruksi induk
    public function instruction()
    {
        return $this->belongsTo(Instruction::class, 'instruction_id');
    }

    // User pengirim tindak lanjut
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // User penerima tindak lanjut
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Forward (tindak lanjut diteruskan)
    public function forwardedUsers()
    {
        return $this->belongsToMany(User::class, 'forward_followup_instructions', 'followup_instruction_id', 'forwarded_to')
            ->withPivot('forwarded_by')
            ->withTimestamps();
    }

    public function forwards()
    {
        return $this->hasMany(ForwardFollowupInstruction::class, 'followup_instruction_id');
    }

    public function followupInstructionScore(){
        return $this->hasMany(FollowupInstructionScore::class, 'followup_instruction_id');
    }
}
