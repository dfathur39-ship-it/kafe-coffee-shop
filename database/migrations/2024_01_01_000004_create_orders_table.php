<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_harga', 12, 2);
            $table->string('status_pesanan', 30)->default('pending');
            $table->string('tipe_pesanan', 20)->default('dine_in');
            $table->string('nomor_meja', 20)->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->string('metode_pembayaran', 50)->nullable()->default('cash');
            $table->string('payment_status', 30)->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('status_pesanan');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
