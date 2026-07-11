<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCache extends Model
{
    use HasFactory;

    protected $table = 'news_cache';

    protected $fillable = [
        'title', 'description', 'content', 'url', 'source_name',
        'image_url', 'category', 'country_id', 'sentiment',
        'sentiment_score', 'is_analyzed', 'published_at',
    ];

    protected $casts = [
        'sentiment_score' => 'integer',
        'is_analyzed'     => 'boolean',
        'published_at'    => 'datetime',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeAnalyzed($query)
    {
        return $query->where('is_analyzed', true);
    }

    public function scopeBySentiment($query, string $sentiment)
    {
        return $query->where('sentiment', $sentiment);
    }
}
