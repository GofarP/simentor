<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('followup_instruction_scores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('followup_instruction_id');
            $table->bigInteger('user_id');
            $table->boolean('score');
            $table->longText('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followup_instruction_scores');
    }
};
