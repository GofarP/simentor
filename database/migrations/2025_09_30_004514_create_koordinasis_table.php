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
        Schema::create('koordinasis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id');
            $table->bigInteger('receiver_id');
            $table->string('title');
            $table->longText('description');
            $table->date('start_time');
            $table->date('end_time');
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koordinasis');
    }
};
