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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('email')->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('no_ktp')->unique()->nullable();
            $table->string('nama');
            $table->string('divisi');
            $table->string('jabatan');
            $table->string('unit_kerja');
            $table->string('status');
            $table->string('jk');
            $table->string('telp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
