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

    // Instruksi yang diterima user
    public function receivedInstructions()
    {
        return $this->hasMany(Instruction::class, 'receiver_id');
    }

    // Forward yang dilakukan user
    public function forwardsMade()
    {
        return $this->hasMany(ForwardInstruction::class, 'forwarded_by');
    }

    // Forward yang diterima user
    public function forwardsReceived()
    {
        return $this->hasMany(ForwardInstruction::class, 'forwarded_to');
    }
}
