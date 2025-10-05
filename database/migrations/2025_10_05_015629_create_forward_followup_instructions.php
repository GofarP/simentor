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
        Schema::create('forward_followup_instructions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('followup_instruction_id');
            $table->bigInteger('forwarded_by');
            $table->bigInteger('forwarded_to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forward_followup_instructions');
    }
};
