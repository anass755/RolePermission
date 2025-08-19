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
        // Create agencies table
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('contact_person_name');
            $table->text('address');
            $table->string('pin');
            $table->string('city');
            $table->string('state_province');
            $table->string('country');
            $table->string('type_of_services');
            $table->string('logo_photo')->nullable();
            $table->text('brief_description')->nullable();
            $table->string('attachment_license')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
        });

        // Create agency_requests table
        Schema::create('agency_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('email');
            $table->string('phone');
            $table->string('contact_person_name');
            $table->text('address');
            $table->string('pin');
            $table->string('city');
            $table->string('state_province');
            $table->string('country');
            $table->string('type_of_services');
            $table->string('logo_photo')->nullable();
            $table->text('brief_description')->nullable();
            $table->string('attachment_license')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_requests');
        Schema::dropIfExists('agencies');
    }
};