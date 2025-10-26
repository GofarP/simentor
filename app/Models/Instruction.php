<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Instruction extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'attachment',
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

            //Hapus semua data di instructionUsers yang terkait dengan instruction ini
            $instruction->instructionUsers()->delete();

            // Hapus followups beserta attachment, proof, forwards, dan scores
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

    // RELASI LAINNYA
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
}
