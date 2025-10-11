<?php

namespace App\Models;

use App\Models\User;
use App\Models\ForwardCoordination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected static function booted()
    {
        static::deleting(function ($coordination) {
            if ($coordination->attachment) {
                Storage::delete($coordination->attachment);
            }

            $coordination->forwards()->delete();

            $coordination->followups->each(function ($followup) {
                if ($followup->attachment) {
                    Storage::delete($followup->attachment);
                }

                if ($followup->proof) {
                    Storage::delete($followup->proof);
                }

                $followup->forwards()->delete();

                $followup->delete();
            });
        });
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function followups()
    {
        return $this->hasMany(FollowupCoordination::class, 'coordination_id');
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
