<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penggunaan', function (Blueprint $table) {
            $table->id('id_penggunaan');
            $table->string('id_pelanggan', 20);
            $table->tinyInteger('bulan');
            $table->year('tahun');
            $table->integer('meter_awal');
            $table->integer('meter_akhir');
            $table->integer('total_kwh')->storedAs('meter_akhir - meter_awal');
            $table->dateTime('tanggal_catat')->useCurrent();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_pelanggan')
                  ->references('id_pelanggan')
                  ->on('pelanggan')
                  ->onDelete('cascade');

            $table->unique(['id_pelanggan', 'bulan', 'tahun'], 'unique_periode');
            $table->index(['tahun', 'bulan'], 'idx_periode');
            $table->index(['id_pelanggan', 'tahun', 'bulan'], 'idx_pelanggan_periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunaan');
    }
};
