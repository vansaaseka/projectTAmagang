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
        Schema::create('kelompoks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ajuan_magang_id')->nullable();
            $table->unsignedBigInteger('anggota_id')->nullable();
            $table->timestamps();

            $table->foreign('ajuan_magang_id')->references('id')->on('ajuan_magangs')->onDelete('cascade');
            $table->foreign('anggota_id')->references('id')->on('anggotas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompoks');
    }
};
