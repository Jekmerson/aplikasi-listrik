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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_tagihan');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->dateTime('tanggal_bayar')->useCurrent();
            $table->enum('metode_bayar', ['Tunai', 'Transfer', 'EDC', 'QRIS'])->default('Tunai');
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_tagihan')
                  ->references('id_tagihan')
                  ->on('tagihan')
                  ->onDelete('restrict');

            $table->index('tanggal_bayar', 'idx_tanggal');
            $table->index('metode_bayar', 'idx_metode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
