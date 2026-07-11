<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('economic_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->integer('year');
            $table->decimal('gdp', 20, 2)->nullable()->comment('GDP in USD');
            $table->decimal('gdp_per_capita', 15, 2)->nullable();
            $table->decimal('inflation_rate', 8, 4)->nullable()->comment('Percentage');
            $table->decimal('exports', 20, 2)->nullable()->comment('Exports in USD');
            $table->decimal('imports', 20, 2)->nullable()->comment('Imports in USD');
            $table->decimal('trade_balance', 20, 2)->nullable();
            $table->string('data_source')->default('world_bank');
            $table->timestamps();

            $table->unique(['country_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('economic_indicators');
    }
};
