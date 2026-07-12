<?php

namespace App\Services;

use App\Models\PositiveWord;
use App\Models\NegativeWord;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SentimentAnalysisService
{
    protected array $positiveWords;
    protected array $negativeWords;

    public function __construct()
    {
        // Cache the lexicons for 24 hours to avoid repeated DB queries (Rule 4A)
        $this->positiveWords = Cache::remember('lexicon_positive', 86400, function () {
            return PositiveWord::pluck('weight', 'word')->toArray();
        });

        $this->negativeWords = Cache::remember('lexicon_negative', 86400, function () {
            return NegativeWord::pluck('weight', 'word')->toArray();
        });
    }

    /**
     * Analyze a given text and return sentiment score and label.
     */
    public function analyze(string $text): array
    {
        if (empty(trim($text))) {
            return ['score' => 0, 'label' => 'neutral'];
        }

        // Tokenize and clean text
        $cleanText = strtolower(preg_replace('/[^a-zA-Z\s]/', '', $text));
        $words = explode(' ', $cleanText);

        $score = 0;

        foreach ($words as $word) {
            $word = trim($word);
            if (empty($word)) continue;

            if (isset($this->positiveWords[$word])) {
                $score += $this->positiveWords[$word];
            } elseif (isset($this->negativeWords[$word])) {
                $score -= $this->negativeWords[$word];
            }
        }

        $label = 'neutral';
        if ($score > 0) {
            $label = 'positive';
        } elseif ($score < 0) {
            $label = 'negative';
        }

        return [
            'score' => $score,
            'label' => $label
        ];
    }
}
