<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->decimal('weather_score', 5, 2)->default(0)->comment('0-100');
            $table->decimal('inflation_score', 5, 2)->default(0)->comment('0-100');
            $table->decimal('political_score', 5, 2)->default(0)->comment('0-100, based on news sentiment');
            $table->decimal('currency_score', 5, 2)->default(0)->comment('0-100');
            $table->decimal('total_score', 5, 2)->default(0)->comment('Weighted: weather*30%+inflation*20%+political*40%+currency*10%');
            $table->enum('risk_level', ['low', 'medium', 'high'])->default('low');
            $table->text('notes')->nullable();
            $table->timestamp('calculated_at');
            $table->timestamps();

            $table->index(['country_id', 'calculated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_scores');
    }
};
