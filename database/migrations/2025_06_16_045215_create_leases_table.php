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
        Schema::create('leases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('cottage_id')->constrained()->onDelete('cascade');
            $table->decimal('monthly_rent', 8, 2);
            $table->date('payment_date');
            $table->date('starts_at');
            $table->date('end_at');
            $table->decimal('deposit_amount');
            $table->enum('status',['active','expired'])->default('active');
            $table->date('lease_expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};
