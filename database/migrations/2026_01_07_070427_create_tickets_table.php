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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->text('description');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('teknician');
            $table->enum('level', ['low', 'medium', 'high', 'critical']);
            $table->dateTime('date');
            $table->enum('status', ['open', 'process', 'closed'])->default('open');
            $table->enum('is_complete', ['nodata', 'like', 'dislike'])->default('nodata');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
