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
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id('id_tagihan');
            $table->unsignedBigInteger('id_penggunaan');
            $table->string('id_pelanggan', 20);
            $table->decimal('total_tagihan', 12, 2);
            $table->dateTime('tanggal_tagihan')->useCurrent();
            $table->date('jatuh_tempo');
            $table->enum('status_bayar', ['Belum Bayar', 'Sudah Bayar', 'Terlambat'])->default('Belum Bayar');
            $table->decimal('denda', 10, 2)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_penggunaan')
                  ->references('id_penggunaan')
                  ->on('penggunaan')
                  ->onDelete('cascade');

            $table->foreign('id_pelanggan')
                  ->references('id_pelanggan')
                  ->on('pelanggan')
                  ->onDelete('cascade');

            $table->index('status_bayar', 'idx_status');
            $table->index('jatuh_tempo', 'idx_jatuh_tempo');
            $table->index('id_pelanggan', 'idx_pelanggan_tagihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
