<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordination extends Model
{
    

    protected $fillable = [
        "sender_id",
        "receiver_id",
        "title",
        "description",
        "start_time",
        "end_time",
        "attachment",
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function forwards()
    {
        return $this->hasMany(ForwardCoordination::class, 'coordination_id', 'id');
    }

    public function forwarder()
    {
        return $this->belongsTo(User::class, 'forwarded_by', 'id');
    }

    public function forwardedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'forward_coordinations',
            'coordination_id',
            'forwarded_to'
        );
    }


}
