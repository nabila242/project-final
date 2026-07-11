<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_comparisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('country_a_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('country_b_id')->constrained('countries')->onDelete('cascade');
            $table->json('snapshot_data')->nullable()->comment('Cached comparison data at time of request');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_comparisons');
    }
};
