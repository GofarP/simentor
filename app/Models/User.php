<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'telp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function instructionsReceived()
    {
        return $this->belongsToMany(Instruction::class, 'instruction_user')
            ->withPivot('sender_id')
            ->withTimestamps();
    }

    public function instructionsSent()
    {
        return $this->belongsToMany(Instruction::class, 'instruction_user')
            ->wherePivot('sender_id', $this->id)
            ->withPivot('sender_id')
            ->withTimestamps();
    }


    public function forwardedInstructions()
    {
        return $this->belongsToMany(Instruction::class, 'forward_instructions', 'forwarded_to', 'instruction_id')
            ->withPivot('forwarded_by')
            ->withTimestamps();
    }

    // === FOLLOWUP INSTRUCTION ===
    public function sentFollowupInstructions()
    {
        return $this->hasMany(FollowupInstruction::class, 'sender_id');
    }

    public function receivedFollowupInstructions()
    {
        return $this->hasMany(FollowupInstruction::class, 'receiver_id');
    }

    public function forwardedFollowupInstructions()
    {
        return $this->belongsToMany(FollowupInstruction::class, 'forward_followup_instructions', 'forwarded_to', 'followup_instruction_id')
            ->withPivot('forwarded_by')
            ->withTimestamps();
    }
}
