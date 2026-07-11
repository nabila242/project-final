<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'gnews_api_key',         'value' => '',          'type' => 'string',  'description' => 'GNews API Key from gnews.io'],
            ['key' => 'exchangerate_api_key',   'value' => '',          'type' => 'string',  'description' => 'ExchangeRate API Key'],
            ['key' => 'weather_cache_hours',    'value' => '3',         'type' => 'integer', 'description' => 'Hours to cache weather data'],
            ['key' => 'news_cache_hours',       'value' => '6',         'type' => 'integer', 'description' => 'Hours to cache news articles'],
            ['key' => 'currency_cache_hours',   'value' => '12',        'type' => 'integer', 'description' => 'Hours to cache currency rates'],
            ['key' => 'world_bank_cache_days',  'value' => '7',         'type' => 'integer', 'description' => 'Days to cache World Bank economic data'],
            ['key' => 'risk_weight_weather',    'value' => '30',        'type' => 'integer', 'description' => 'Risk score weight for weather (%)'],
            ['key' => 'risk_weight_inflation',  'value' => '20',        'type' => 'integer', 'description' => 'Risk score weight for inflation (%)'],
            ['key' => 'risk_weight_political',  'value' => '40',        'type' => 'integer', 'description' => 'Risk score weight for political/news sentiment (%)'],
            ['key' => 'risk_weight_currency',   'value' => '10',        'type' => 'integer', 'description' => 'Risk score weight for currency volatility (%)'],
            ['key' => 'maintenance_mode',       'value' => 'false',     'type' => 'boolean', 'description' => 'Put the platform in maintenance mode'],
            ['key' => 'platform_name',          'value' => 'Supply Chain Risk Intelligence', 'type' => 'string', 'description' => 'Platform display name'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
