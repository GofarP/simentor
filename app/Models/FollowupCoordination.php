<?php

namespace App\Models;

use Faker\Core\Coordinates;
use Illuminate\Database\Eloquent\Model;

class FollowupCoordination extends Model
{
    protected $fillable = [
        "coordination_id",
        "sender_id",
        "receiver_id",
        "attachment",
        "description"
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

    public function forwardedUsers()
    {
        return $this->belongsToMany(User::class, 'forward_followup_coordinations', 'followup_coordination_id', 'forwarded_to')
            ->withPivot('forwarded_by')
            ->withTimestamps();
    }

    public function forwards()
    {
        return $this->hasMany(ForwardFollowupCoordination::class, 'followup_coordination_id');
    }
}
