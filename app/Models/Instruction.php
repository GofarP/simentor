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
    // Pengirim
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Penerima (asumsi single user, jika multiple array gunakan belongsToMany)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Instruction.php
    public function forwards()
    {
        return $this->hasMany(ForwardInstruction::class, 'instruction_id', 'id');
    }

    // ForwardInstruction.php
    public function forwarder()
    {
        return $this->belongsTo(User::class, 'forwarded_by', 'id');
    }

    // Semua penerima forward (jika ingin ambil user langsung)
    public function forwardedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'forward_instructions',
            'instruction_id',
            'forwarded_to'
        );
    }

}
