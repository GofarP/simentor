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
        Schema::table('coordinations', function (Blueprint $table) {
            if (Schema::hasColumn('coordinations', 'sender_id')) {
                $table->dropColumn('sender_id');
            }
            if (Schema::hasColumn('coordinations', 'receiver_id')) {
                $table->dropColumn('receiver_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coordinations', function (Blueprint $table) {
            //
        });
    }
};
