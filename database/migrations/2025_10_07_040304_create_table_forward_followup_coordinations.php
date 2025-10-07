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
        Schema::create('forward_followup_coordinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('followup_coordination_id');
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
        Schema::dropIfExists('table_forward_followup_coordinations');
    }
};
