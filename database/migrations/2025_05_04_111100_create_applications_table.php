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
        Schema::create('applications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // If you're linking the rent to a user
        $table->string('phone');
        $table->string('dob');
        $table->string('id_number');
        $table->string('current_address');
        $table->integer('occupants');
        $table->boolean('pets')->nullable(); // If it's a checkbox
        $table->string('employer');
        $table->string('job_title');
        $table->string('employment_start');
        $table->string('monthly_income', 10, 2);
        $table->string('employer_contact');
        $table->string('landlord_name');
        $table->string('landlord_contact');
        $table->string('rent_amount', 10, 2);
        $table->string('reason_leaving');
        $table->string('revoked_reason')->nullable();
        $table->string('status')->default('pending');
        $table->boolean('agree');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
