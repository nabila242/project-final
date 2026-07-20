<?php

use App\Models\Country;
use App\Models\NewsCache;

$c = Country::first();

NewsCache::create([
    'title'=>'Global Supply Chain Recovers as Shipping Costs Drop',
    'description'=>'Major improvements in global logistics have led to a boom in trade surplus and massive profit growth.',
    'url'=>'https://example.com/1',
    'category'=>'business',
    'country_id'=>$c->id,
    'sentiment'=>'positive',
    'sentiment_score'=>9,
    'is_analyzed'=>true,
    'published_at'=>now()
]);

NewsCache::create([
    'title'=>'Port Strikes Cause Major Logistics Delay',
    'description'=>'A sudden strike in major ports has caused a crisis and shortage of essential materials, triggering a sharp decline in stocks.',
    'url'=>'https://example.com/2',
    'category'=>'business',
    'country_id'=>$c->id,
    'sentiment'=>'negative',
    'sentiment_score'=>-7,
    'is_analyzed'=>true,
    'published_at'=>now()
]);

NewsCache::create([
    'title'=>'Trade Agreement Signed Between Two Major Economies',
    'description'=>'A new partnership has been signed which is expected to provide stable opportunity and good cooperation.',
    'url'=>'https://example.com/3',
    'category'=>'business',
    'country_id'=>$c->id,
    'sentiment'=>'positive',
    'sentiment_score'=>5,
    'is_analyzed'=>true,
    'published_at'=>now()
]);

NewsCache::create([
    'title'=>'Market Remains Volatile Amid Uncertainty',
    'description'=>'Investors remain cautious as the market shows weak movement today. Concerns over global events persist.',
    'url'=>'https://example.com/4',
    'category'=>'business',
    'country_id'=>$c->id,
    'sentiment'=>'neutral',
    'sentiment_score'=>0,
    'is_analyzed'=>true,
    'published_at'=>now()
]);

echo "Dummy news seeded!\n";
