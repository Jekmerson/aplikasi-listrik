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
        Schema::create('tarif', function (Blueprint $table) {
            $table->id('id_tarif');
            $table->string('nama_tarif', 50);
            $table->decimal('tarif_per_kwh', 10, 2);
            $table->decimal('biaya_beban', 10, 2)->default(0);
            $table->date('berlaku_dari');
            $table->date('berlaku_sampai')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['berlaku_dari', 'berlaku_sampai'], 'idx_berlaku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarif');
    }
};
