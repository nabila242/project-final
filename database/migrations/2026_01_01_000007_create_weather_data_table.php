<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->decimal('temperature', 6, 2)->nullable()->comment('Celsius');
            $table->decimal('precipitation', 6, 2)->nullable()->comment('mm');
            $table->decimal('wind_speed', 6, 2)->nullable()->comment('km/h');
            $table->decimal('wind_gusts', 6, 2)->nullable();
            $table->tinyInteger('weather_code')->nullable()->comment('WMO code');
            $table->decimal('storm_risk', 5, 2)->nullable()->comment('0-100 score');
            $table->timestamp('recorded_at');
            $table->timestamps();

            $table->index(['country_id', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
