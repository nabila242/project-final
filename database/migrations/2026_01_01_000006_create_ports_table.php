<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ports', function (Blueprint $table) {
            $table->id();
            $table->string('wpi_number')->nullable()->comment('World Port Index number');
            $table->string('name');
            $table->string('country_code', 3)->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->string('region')->nullable();
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('harbor_type')->nullable();
            $table->string('harbor_size')->nullable()->comment('V=Very Large, L=Large, M=Medium, S=Small');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['latitude', 'longitude']);
            $table->index('country_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};
