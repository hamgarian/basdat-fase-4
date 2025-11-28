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
        Schema::create('hazard_report', function (Blueprint $table) {
            $table->id('id_hazard');
            $table->unsignedBigInteger('id_karyawan');
            $table->string('nama_pelapor', 100)->nullable();
            $table->date('tanggal_laporan');
            $table->string('kategori', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('status', 30)->default('Open');
            $table->timestamps();
            
            $table->foreign('id_karyawan')
                ->references('id_karyawan')
                ->on('karyawan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_report');
    }
};
