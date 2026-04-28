<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom desa_id
            $table->unsignedBigInteger('desa_id')->after('email')->nullable();

            // Kalau ada relasi foreign key ke tabel desa
            $table->foreign('desa_id')->references('id')->on('desa')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['desa_id']);
            $table->dropColumn('desa_id');
        });
    }
    
};
