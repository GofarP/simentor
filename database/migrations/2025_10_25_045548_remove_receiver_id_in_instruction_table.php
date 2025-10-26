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
        Schema::table('instructions', function (Blueprint $table) {
            if (Schema::hasColumn('instructions', 'sender_id')) {
                $table->dropColumn('sender_id');
            }
            if (Schema::hasColumn('instructions', 'receiver_id')) {
                $table->dropColumn('receiver_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instruction', function (Blueprint $table) {
            //
        });
    }
};
