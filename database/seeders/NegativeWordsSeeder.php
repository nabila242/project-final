<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NegativeWord;

class NegativeWordsSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            // Weight 3 — sangat negatif
            ['word' => 'war',           'weight' => 3],
            ['word' => 'conflict',      'weight' => 3],
            ['word' => 'sanction',      'weight' => 3],
            ['word' => 'collapse',      'weight' => 3],
            ['word' => 'crisis',        'weight' => 3],
            ['word' => 'recession',     'weight' => 3],
            ['word' => 'bankruptcy',    'weight' => 3],
            ['word' => 'embargo',       'weight' => 3],
            ['word' => 'default',       'weight' => 3],
            ['word' => 'shortage',      'weight' => 3],
            // Weight 2 — cukup negatif
            ['word' => 'decline',       'weight' => 2],
            ['word' => 'fall',          'weight' => 2],
            ['word' => 'drop',          'weight' => 2],
            ['word' => 'loss',          'weight' => 2],
            ['word' => 'risk',          'weight' => 2],
            ['word' => 'inflation',     'weight' => 2],
            ['word' => 'tariff',        'weight' => 2],
            ['word' => 'delay',         'weight' => 2],
            ['word' => 'disruption',    'weight' => 2],
            ['word' => 'protest',       'weight' => 2],
            ['word' => 'strike',        'weight' => 2],
            ['word' => 'deficit',       'weight' => 2],
            ['word' => 'debt',          'weight' => 2],
            ['word' => 'tension',       'weight' => 2],
            ['word' => 'uncertainty',   'weight' => 2],
            // Weight 1 — sedikit negatif
            ['word' => 'slow',          'weight' => 1],
            ['word' => 'weak',          'weight' => 1],
            ['word' => 'concern',       'weight' => 1],
            ['word' => 'challenge',     'weight' => 1],
            ['word' => 'problem',       'weight' => 1],
            ['word' => 'issue',         'weight' => 1],
            ['word' => 'warning',       'weight' => 1],
            ['word' => 'downgrade',     'weight' => 1],
            ['word' => 'cost',          'weight' => 1],
            ['word' => 'pressure',      'weight' => 1],
            ['word' => 'volatile',      'weight' => 1],
            ['word' => 'bearish',       'weight' => 1],
            ['word' => 'restriction',   'weight' => 1],
            ['word' => 'barrier',       'weight' => 1],
            ['word' => 'flood',         'weight' => 1],
        ];

        foreach ($words as $word) {
            NegativeWord::firstOrCreate(
                ['word' => $word['word']],
                ['weight' => $word['weight']]
            );
        }
    }
}
