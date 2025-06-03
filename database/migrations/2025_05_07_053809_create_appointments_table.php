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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('cottage_number');
            $table->date('preferred_date');
            $table->string('preferred_time');
            $table->string('proposed_time')->nullable();
            $table->string('message');
            $table->enum('status',['pending', 'confirmed','declined','revoked'])->default('pending');
            $table->text('revoked_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
