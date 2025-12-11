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
        // Add indexes for frequently queried columns in hazard_report
        Schema::table('hazard_report', function (Blueprint $table) {
            $table->index('status');
            $table->index('tanggal_laporan');
            $table->index('kategori');
            $table->index(['status', 'tanggal_laporan']);
        });

        // Add indexes for pesawat queries
        Schema::table('pesawat', function (Blueprint $table) {
            $table->index('status');
            $table->index('registrasi');
        });

        // Add indexes for pilot queries
        Schema::table('pilot', function (Blueprint $table) {
            $table->index('status');
            $table->index('lisensi_pilot');
        });

        // Add indexes for incident queries
        Schema::table('incident', function (Blueprint $table) {
            $table->index('id_incident');
        });

        // Add indexes for investigation queries
        Schema::table('investigation', function (Blueprint $table) {
            $table->index('tanggal_mulai');
            $table->index('id_hazard');
        });

        // Add indexes for audit queries
        Schema::table('audit', function (Blueprint $table) {
            $table->index('tanggal_pelaksanaan');
        });

        // Add indexes for temuan queries
        Schema::table('temuan', function (Blueprint $table) {
            $table->index('id_audit');
        });

        // Add indexes for library_manual queries
        Schema::table('library_manual', function (Blueprint $table) {
            $table->index('tanggal_terbit');
        });

        // Add indexes for penerbangan queries
        Schema::table('penerbangan', function (Blueprint $table) {
            $table->index('tanggal_penerbangan');
        });

        // Add indexes for flight_movement queries
        Schema::table('flight_movement', function (Blueprint $table) {
            $table->index('tanggal_penerbangan');
        });

        // Add indexes for client queries
        Schema::table('client', function (Blueprint $table) {
            $table->index('nama_perusahaan');
        });

        // Add indexes for karyawan queries
        Schema::table('karyawan', function (Blueprint $table) {
            $table->index('nama_karyawan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hazard_report', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['tanggal_laporan']);
            $table->dropIndex(['kategori']);
            $table->dropIndex(['status', 'tanggal_laporan']);
        });

        Schema::table('pesawat', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['registrasi']);
        });

        Schema::table('pilot', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['lisensi_pilot']);
        });

        Schema::table('incident', function (Blueprint $table) {
            $table->dropIndex(['id_incident']);
        });

        Schema::table('investigation', function (Blueprint $table) {
            $table->dropIndex(['tanggal_mulai']);
            $table->dropIndex(['id_hazard']);
        });

        Schema::table('audit', function (Blueprint $table) {
            $table->dropIndex(['tanggal_pelaksanaan']);
        });

        Schema::table('temuan', function (Blueprint $table) {
            $table->dropIndex(['id_audit']);
        });

        Schema::table('library_manual', function (Blueprint $table) {
            $table->dropIndex(['tanggal_terbit']);
        });

        Schema::table('penerbangan', function (Blueprint $table) {
            $table->dropIndex(['tanggal_penerbangan']);
        });

        Schema::table('flight_movement', function (Blueprint $table) {
            $table->dropIndex(['tanggal_penerbangan']);
        });

        Schema::table('client', function (Blueprint $table) {
            $table->dropIndex(['nama_perusahaan']);
        });

        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropIndex(['nama_karyawan']);
        });
    }
};
