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
        Schema::create('transaksi_iurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id');
            $table->string('kategori_iuran', 50);
            $table->string('bulan', 10);
            $table->year('tahun');
            $table->date('tanggal_iuran');
            $table->string('nominal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_iurans');
    }
};
