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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->string('id_pelanggan', 20)->primary();
            $table->string('nama_pelanggan', 100);
            $table->text('alamat');
            $table->string('no_telepon', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->unsignedBigInteger('id_daya_listrik');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->date('tanggal_registrasi');
            $table->enum('status', ['Aktif', 'Nonaktif', 'Suspend'])->default('Aktif');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_daya_listrik')
                  ->references('id_daya_listrik')
                  ->on('daya_listrik')
                  ->onDelete('restrict');

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('user')
                  ->onDelete('set null');

            $table->index('nama_pelanggan', 'idx_nama');
            $table->index('status', 'idx_status');
            $table->index('id_daya_listrik', 'idx_daya_pelanggan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
