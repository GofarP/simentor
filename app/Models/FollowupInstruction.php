<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowupInstruction extends Model
{
    protected $fillable=[
        "instruction_id",
        "proof",
        "attachment",
        "description"
    ];

    public function instruction(){
        return $this->hasMany(Instruction::class, 'instruction_id');
    }
}
