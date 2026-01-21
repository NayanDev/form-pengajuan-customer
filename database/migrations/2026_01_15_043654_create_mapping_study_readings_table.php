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
        Schema::create('mapping_study_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapping_study_point_id')->constrained('mapping_study_points')->onDelete('cascade');
            $table->float('value', 5,2);
            $table->dateTime('recorded_at');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapping_study_readings');
    }
};
