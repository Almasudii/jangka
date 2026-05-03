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
        Schema::create('wilayah_boundaries', function (Blueprint $table) {
            $table->string('kode', 13)->unique(); // UNIQUE INDEX
            $table->string('nama', 100)->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->longText('path')->nullable();
            $table->integer('status')->nullable();

            $table->primary('kode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah_boundaries');
    }
};
