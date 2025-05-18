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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('total', 12, 2);
            $table->enum('payment_method', ['cash', 'qris', 'debit_card', 'credit_card', 'e_wallet']);
            $table->decimal('cash_received', 12, 2)->nullable();
            $table->decimal('change', 12, 2)->nullable();
            $table->string('cashier_name');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
