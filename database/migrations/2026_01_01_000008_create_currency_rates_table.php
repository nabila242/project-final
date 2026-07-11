<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->string('base_currency', 10)->default('USD');
            $table->string('target_currency', 10);
            $table->decimal('rate', 15, 6);
            $table->decimal('change_percent', 8, 4)->nullable()->comment('% change from previous');
            $table->date('rate_date');
            $table->timestamps();

            $table->index(['base_currency', 'target_currency', 'rate_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_rates');
    }
};
