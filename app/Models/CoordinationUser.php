<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoordinationUser extends Model
{
    protected $fillable = [
        "coordination_id",
        "sender_id",
        "receiver_id"
    ];

    public function coordination()
    {
        return $this->belongsTo(Coordination::class, 'coordination_id');
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
