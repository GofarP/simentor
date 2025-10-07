<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructionScore extends Model
{
    protected $fillable = [
        "instruction_id",
        "user_id",
        'score'
    ];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
