<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositiveWord;

class PositiveWordsSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            // Weight 3 — sangat positif
            ['word' => 'growth',        'weight' => 3],
            ['word' => 'surge',         'weight' => 3],
            ['word' => 'boom',          'weight' => 3],
            ['word' => 'profit',        'weight' => 3],
            ['word' => 'record',        'weight' => 3],
            ['word' => 'breakthrough',  'weight' => 3],
            ['word' => 'success',       'weight' => 3],
            ['word' => 'surplus',       'weight' => 3],
            ['word' => 'expansion',     'weight' => 3],
            ['word' => 'recovery',      'weight' => 3],
            // Weight 2 — cukup positif
            ['word' => 'increase',      'weight' => 2],
            ['word' => 'gain',          'weight' => 2],
            ['word' => 'improve',       'weight' => 2],
            ['word' => 'rise',          'weight' => 2],
            ['word' => 'positive',      'weight' => 2],
            ['word' => 'stable',        'weight' => 2],
            ['word' => 'invest',        'weight' => 2],
            ['word' => 'agreement',     'weight' => 2],
            ['word' => 'deal',          'weight' => 2],
            ['word' => 'partnership',   'weight' => 2],
            ['word' => 'export',        'weight' => 2],
            ['word' => 'strengthen',    'weight' => 2],
            ['word' => 'opportunity',   'weight' => 2],
            ['word' => 'efficient',     'weight' => 2],
            ['word' => 'reform',        'weight' => 2],
            // Weight 1 — sedikit positif
            ['word' => 'good',          'weight' => 1],
            ['word' => 'better',        'weight' => 1],
            ['word' => 'strong',        'weight' => 1],
            ['word' => 'open',          'weight' => 1],
            ['word' => 'support',       'weight' => 1],
            ['word' => 'benefit',       'weight' => 1],
            ['word' => 'advance',       'weight' => 1],
            ['word' => 'progress',      'weight' => 1],
            ['word' => 'boost',         'weight' => 1],
            ['word' => 'confidence',    'weight' => 1],
            ['word' => 'optimistic',    'weight' => 1],
            ['word' => 'trade',         'weight' => 1],
            ['word' => 'cooperation',   'weight' => 1],
            ['word' => 'innovation',    'weight' => 1],
            ['word' => 'opportunity',   'weight' => 1],
        ];

        // Remove duplicates before inserting
        $unique = collect($words)->unique('word')->values()->toArray();

        foreach ($unique as $word) {
            PositiveWord::firstOrCreate(
                ['word' => $word['word']],
                ['weight' => $word['weight']]
            );
        }
    }
}
