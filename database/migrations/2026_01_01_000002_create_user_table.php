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
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('nama_lengkap', 100);
            $table->string('email', 100)->nullable();
            $table->unsignedBigInteger('id_level');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_level')
                  ->references('id_level')
                  ->on('level')
                  ->onDelete('restrict');

            $table->index('username');
            $table->index('id_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
