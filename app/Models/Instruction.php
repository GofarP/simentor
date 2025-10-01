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

    public function forward(){
        return $this->belongsTo(User::class,'instruction_id');
    }
}
