<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForwardInstruction extends Model
{
    protected $fillable = [
        "instruction_id",
        "forwarded_by",
        "forwarded_to"
    ];

    // Instruksi yang dikirim user

    public function instruction()
    {
        return $this->belongsTo(Instruction::class, 'instruction_id');
    }

    public function forwarder()
    {
        return $this->belongsTo(User::class, 'forwarded_by','id');
    }

    // User penerima forward
    public function receiver()
    {
        return $this->belongsTo(User::class, 'forwarded_to','id');
    }


}
