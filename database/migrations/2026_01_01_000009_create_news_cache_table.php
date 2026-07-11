<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_cache', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('url')->unique();
            $table->string('source_name')->nullable();
            $table->string('image_url')->nullable();
            $table->string('category')->nullable()->comment('e.g. logistics, geopolitics, trade');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->enum('sentiment', ['positive', 'neutral', 'negative'])->default('neutral');
            $table->integer('sentiment_score')->default(0);
            $table->boolean('is_analyzed')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['sentiment', 'category']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_cache');
    }
};
