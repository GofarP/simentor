<?php

namespace App\Models;

use App\Models\User;
use App\Models\InstructionUser;
use App\Models\ForwardInstruction;
use App\Models\FollowupInstruction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\FollowupInstructionScore;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Instruction extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'attachment',
    ];

    protected $casts = [
        'start_time' => 'date',
        'end_time' => 'date',
    ];

    protected static function booted()
    {
        static::deleting(function ($instruction) {
            if ($instruction->attachment) {
                Storage::delete($instruction->attachment);
            }

            $instruction->forwards()->delete();

            $instruction->instructionUsers()->delete();

            $instruction->followups->each(function ($followup) {
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
        return $this->belongsToMany(User::class, 'instruction_users', 'instruction_id', 'sender_id')
            ->withPivot('receiver_id')
            ->withTimestamps();
    }

    public function receivers()
    {

        return $this->belongsToMany(User::class, 'instruction_users', 'instruction_id', 'receiver_id')
            ->withPivot('sender_id')
            ->withTimestamps();
    }

    public function followups()
    {
        return $this->hasMany(FollowupInstruction::class, 'instruction_id');
    }

    public function forwardedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'forward_instructions',
            'instruction_id',
            'forwarded_to'
        )->withPivot('forwarded_by')
            ->withTimestamps();
    }

    public function forwards()
    {
        return $this->hasMany(ForwardInstruction::class, 'instruction_id');
    }

    public function scores()
    {
        return $this->hasMany(FollowupInstructionScore::class, 'instruction_id');
    }

    public function instructionUsers()
    {
        return $this->hasMany(InstructionUser::class, 'instruction_id');
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

    protected function instructionSenderId(): Attribute
    {
        return Attribute::make(
            get: fn() => optional($this->instructionUsers->first())->sender_id
        );
    }


    protected function isSender(): Attribute
    {
        return Attribute::make(
            get: fn() => Auth::id() === $this->instruction_sender_id
        );
    }
    public function instructionScore()
    {
        return $this->hasMany(InstructionScore::class, 'instruction_id');
    }


}
