<?php

namespace App\Models;

use App\Models\User;
use App\Models\CoordinationUser;
use App\Models\ForwardCoordination;
use App\Models\FollowupCoordination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Coordination extends Model
{


    protected $fillable = [
        "title",
        "description",
        "start_time",
        "end_time",
        "attachment",
    ];

    protected $casts = [
        'end_time' => 'date',
    ];

    protected static function booted()
    {
        static::deleting(function ($coordination) {
            if ($coordination->attachment) {
                Storage::delete($coordination->attachment);
            }

            $coordination->forwards()->delete();

            $coordination->followups->each(function ($followup) {
                if ($followup->attachment) Storage::delete($followup->attachment);
                if ($followup->proof) Storage::delete($followup->proof);
                $followup->forwards()->delete();
                if (method_exists($followup, 'scores')) {
                    $followup->scores()->delete();
                }
                $followup->delete();
            });
        });
    }

    public function senders()
    {
        return $this->belongsToMany(User::class, 'coordination_users', 'coordination_id', 'sender_id')
            ->withPivot('receiver_id')
            ->withTimestamps();
    }

    public function receivers()
    {

        return $this->belongsToMany(User::class, 'coordination_users', 'coordination_id', 'receiver_id')
            ->withPivot('sender_id')
            ->withTimestamps();
    }


    public function followups()
    {
        return $this->hasMany(FollowupCoordination::class, 'coordination_id');
    }

    public function forwardedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'forward_coordinations',
            'coordination_id',
            'forwarded_to'
        )->withPivot('forwarded_by')
            ->withTimestamps();
    }

    public function forwards()
    {
        return $this->hasMany(ForwardCoordination::class, 'coordination_id');
    }


    public function coordinationUsers()
    {
        return $this->hasMany(CoordinationUser::class, 'coordination_id');
    }

    protected function isExpired(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {

                if (empty($attributes['end_time'])) {
                    return false;
                }

                $expiryPoint = $this->end_time->endOfDay();

                return now()->gt($expiryPoint);
            }
        );
    }


    protected function coordinationSenderId(): Attribute
    {
        return Attribute::make(
            get: fn() => optional($this->coordinationUsers->first())->sender_id
        );
    }

    protected function isSender(): Attribute
    {
        return Attribute::make(
            get: fn() => Auth::id() === $this->coordination_sender_id
        );
    }
}
