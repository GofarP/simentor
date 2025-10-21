<?php

namespace App\Models;

use App\Models\User;
use App\Models\FollowupInstructionScore;
use App\Models\ForwardInstruction;
use App\Models\FollowupInstruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected static function booted()
    {
        static::deleting(function ($instruction) {
            if ($instruction->attachment) {
                Storage::delete($instruction->attachment);
            }

            $instruction->forwards()->delete();

            $instruction->followups->each(function ($followup) {
                if ($followup->attachment) {
                    Storage::delete($followup->attachment);
                }

                if ($followup->proof) {
                    Storage::delete($followup->proof);
                }

                $followup->forwards()->delete();

                $followup->delete();
            });

            if (method_exists($instruction, 'scores')) {
                $instruction->scores()->delete();
            }
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
        return $this->hasMany(FollowupInstruction::class, 'instruction_id');
    }

    public function forwardedUsers()
    {
        return $this->belongsToMany(User::class, 'forward_instructions', 'instruction_id', 'forwarded_to')
            ->withPivot('forwarded_by')
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
}
