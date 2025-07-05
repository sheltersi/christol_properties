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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')->constrained()->cascadeOnDelete();
            $table->string('month_for');          // 2025‑06‑01 convention
            $table->decimal('amount_paid', 8, 2)->nullable(); // null until proof uploaded
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('date');
            $table->string('reference');          // 2025‑06‑01 convention
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
