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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('tanggal_registrasi')->nullable();

            // enum fields
            $table->enum('status_customer', ['Baru', 'Perubahan'])->nullable();
            $table->enum('cabang_pengajuan', ['Pusat', 'Cabang Semarang', 'Cabang Makassar', 'Cabang Manado', 'MBI'])->nullable();
            $table->enum('tipe_customer', ['H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'H7', 'H8', 'H9'])->nullable();

            // customer info
            $table->string('nama_customer', 100)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('alamat_email', 100)->nullable();
            $table->string('no_ktp', 50)->nullable();
            $table->text('alamat_outlet')->nullable();
            $table->string('no_fax', 50)->nullable();

            // PIC info
            $table->string('nama_pic', 100)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->text('alasan_perubahan')->nullable();

            // outlet info
            $table->string('izin_operasional', 100)->nullable();
            $table->date('masa_berlaku_izin_operasional')->nullable();
            $table->string('sipa', 100)->nullable();
            $table->date('masa_berlaku_sipa')->nullable();
            $table->string('cdob', 100)->nullable();
            $table->date('masa_berlaku_cdob')->nullable();
            $table->string('no_npwp_outlet', 50)->nullable();
            $table->string('nama_npwp', 100)->nullable();
            $table->text('alamat_npwp')->nullable();

            // finance & sales
            $table->string('id_sales', 255)->nullable();
            $table->string('gl_akun_piutang', 100)->nullable();
            $table->string('sumber_dana', 100)->nullable();

            // other info
            $table->text('ttd_apj')->nullable();
            $table->string('nama_terang', 100)->nullable();
            $table->string('dokumen_pendukung', 500)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
