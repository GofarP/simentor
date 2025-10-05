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

    // Relasi ke user pengirim
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relasi ke user penerima
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Tindak lanjut instruksi
    public function followups()
    {
        return $this->hasMany(FollowupInstruction::class, 'instruction_id');
    }

    // Forward (instruksi diteruskan ke user lain)
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
