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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->nullable(); // City code
            $table->foreignId('state_id')->constrained('states')->onDelete('cascade');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['state_id', 'status']);
            $table->unique(['state_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};