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
            // Hapus attachment utama Instruction
            if ($instruction->attachment) {
                Storage::delete($instruction->attachment);
            }

            // Hapus semua data forwards yang terkait langsung dengan Instruction
            $instruction->forwards()->delete();

            // Loop semua followup terkait Instruction
            $instruction->followups->each(function ($followup) {
                // Hapus file lampiran followup
                if ($followup->attachment) {
                    Storage::delete($followup->attachment);
                }

                // Hapus file proof followup
                if ($followup->proof) {
                    Storage::delete($followup->proof);
                }

                // Hapus semua forwards di followup
                $followup->forwards()->delete();

                // Jika followup memiliki relasi scores, hapus juga (aman)
                if (method_exists($followup, 'scores')) {
                    $followup->scores()->delete();
                }

                // Terakhir hapus followup itu sendiri
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
