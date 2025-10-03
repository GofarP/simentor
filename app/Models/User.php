<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telp',
        'pengirim_id',
        'penerima_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    public function sentInstructions()
    {
        return $this->hasMany(Instruction::class, 'sender_id');
    }

    public function sentCoordination(){
        return $this->hasMany(Coordination::class, 'sender_id');
    }

    public function sentFollowupInstruction(){
        return $this->hasMany(FollowupInstruction::class,'sender_id');
    }

    public function receivedInstructions()
    {
        return $this->hasMany(Instruction::class, 'receiver_id');
    }


    public function receivedCoordination()
    {
        return $this->hasMany(Coordination::class,'receiver_id');
    }

    public function receivedFollowupInstructions(){
        return $this->hasMany(FollowupInstruction::class, 'receiver_id');
    }

    public function forwardedInstructions()
    {
        return $this->belongsToMany(Instruction::class, 'forward_instructions', 'forwarded_to', 'instruction_id')
            ->withPivot('forwarded_by')
            ->withTimestamps();
    }

    public function forwardedCoordinations()
    {
        return $this->belongsToMany(Coordination::class, 'forward_coordinations','forwarded_to','instruction_id')
        ->withPivot('forwarded_by')
        ->withTimestamps();
    }

    public function forwardedFollowupInstructions(){
        return $this->belongsToMany(FollowupInstruction::class, 'forward_followup_instructions','forwarded_to','followup_instruction_id')
        ->withPivot('forwarded_by')
        ->withTimestamps();
    }
}

