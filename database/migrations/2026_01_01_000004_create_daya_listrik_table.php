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
        Schema::create('daya_listrik', function (Blueprint $table) {
            $table->id('id_daya_listrik');
            $table->integer('daya_watt')->unique();
            $table->unsignedBigInteger('id_tarif');
            $table->string('keterangan', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_tarif')
                  ->references('id_tarif')
                  ->on('tarif')
                  ->onDelete('restrict');

            $table->index('daya_watt', 'idx_daya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daya_listrik');
    }
};
