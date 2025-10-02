<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForwardCoordination extends Model
{
    protected $fillable = [
        "coordination_id",
        "forwarded_by",
        "forwarded_to"
    ];

    public function coordination()
    {
        return $this->belongsTo(Coordination::class, 'coordination_id');
    }

    public function forwarder()
    {
        return $this->belongsTo(User::class, 'forwarded_by', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'forwarded_to', 'id');
    }

}
