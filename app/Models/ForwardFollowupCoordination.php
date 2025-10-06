<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForwardFollowupCoordination extends Model
{
    protected $fillable = [
        "followup_coordination_id",
        "forwarded_by",
        "forwarded_to"
    ];

    public function followupCoordination()
    {
        return $this->belongsTo(FollowupInstruction::class, 'followup_coordination_id');
    }

    public function forwarder()
    {
        return $this->belongsTo(User::class, 'forwarded_by');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'forwarded_to');
    }
}
