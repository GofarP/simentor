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
        Schema::table('followup_instructions', function (Blueprint $table) {
            $table->bigInteger('sender_id');
            $table->bigInteger('receiver_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('followup_instruction', function (Blueprint $table) {
            //
        });
    }
};
