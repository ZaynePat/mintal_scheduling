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
        Schema::table('faculty', function (Blueprint $table) {
            // Check if the column does not exist before adding it
            if (!Schema::hasColumn('faculty', 'profile_image')) {
                $table->string('profile_image')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculty', function (Blueprint $table) {
            if (Schema::hasColumn('faculty', 'profile_image')) {
                $table->dropColumn('profile_image');
            }
        });
    }
};
