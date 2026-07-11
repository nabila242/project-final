<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['code' => 'USA', 'code2' => 'US', 'name' => 'United States', 'capital' => 'Washington, D.C.', 'region' => 'Americas', 'subregion' => 'Northern America', 'latitude' => 38.9072, 'longitude' => -77.0369, 'currency_code' => 'USD', 'currency_name' => 'US Dollar', 'population' => 331000000, 'language' => 'English'],
            ['code' => 'CHN', 'code2' => 'CN', 'name' => 'China', 'capital' => 'Beijing', 'region' => 'Asia', 'subregion' => 'Eastern Asia', 'latitude' => 39.9042, 'longitude' => 116.4074, 'currency_code' => 'CNY', 'currency_name' => 'Chinese Yuan', 'population' => 1411000000, 'language' => 'Mandarin'],
            ['code' => 'DEU', 'code2' => 'DE', 'name' => 'Germany', 'capital' => 'Berlin', 'region' => 'Europe', 'subregion' => 'Western Europe', 'latitude' => 52.5200, 'longitude' => 13.4050, 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'population' => 83000000, 'language' => 'German'],
            ['code' => 'JPN', 'code2' => 'JP', 'name' => 'Japan', 'capital' => 'Tokyo', 'region' => 'Asia', 'subregion' => 'Eastern Asia', 'latitude' => 35.6762, 'longitude' => 139.6503, 'currency_code' => 'JPY', 'currency_name' => 'Japanese Yen', 'population' => 125000000, 'language' => 'Japanese'],
            ['code' => 'IND', 'code2' => 'IN', 'name' => 'India', 'capital' => 'New Delhi', 'region' => 'Asia', 'subregion' => 'Southern Asia', 'latitude' => 28.6139, 'longitude' => 77.2090, 'currency_code' => 'INR', 'currency_name' => 'Indian Rupee', 'population' => 1380000000, 'language' => 'Hindi'],
            ['code' => 'GBR', 'code2' => 'GB', 'name' => 'United Kingdom', 'capital' => 'London', 'region' => 'Europe', 'subregion' => 'Northern Europe', 'latitude' => 51.5074, 'longitude' => -0.1278, 'currency_code' => 'GBP', 'currency_name' => 'British Pound', 'population' => 67000000, 'language' => 'English'],
            ['code' => 'FRA', 'code2' => 'FR', 'name' => 'France', 'capital' => 'Paris', 'region' => 'Europe', 'subregion' => 'Western Europe', 'latitude' => 48.8566, 'longitude' => 2.3522, 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'population' => 67000000, 'language' => 'French'],
            ['code' => 'BRA', 'code2' => 'BR', 'name' => 'Brazil', 'capital' => 'Brasília', 'region' => 'Americas', 'subregion' => 'South America', 'latitude' => -15.7975, 'longitude' => -47.8919, 'currency_code' => 'BRL', 'currency_name' => 'Brazilian Real', 'population' => 212000000, 'language' => 'Portuguese'],
            ['code' => 'RUS', 'code2' => 'RU', 'name' => 'Russia', 'capital' => 'Moscow', 'region' => 'Europe', 'subregion' => 'Eastern Europe', 'latitude' => 55.7558, 'longitude' => 37.6173, 'currency_code' => 'RUB', 'currency_name' => 'Russian Ruble', 'population' => 145000000, 'language' => 'Russian'],
            ['code' => 'AUS', 'code2' => 'AU', 'name' => 'Australia', 'capital' => 'Canberra', 'region' => 'Oceania', 'subregion' => 'Australia and New Zealand', 'latitude' => -35.2809, 'longitude' => 149.1300, 'currency_code' => 'AUD', 'currency_name' => 'Australian Dollar', 'population' => 25000000, 'language' => 'English'],
            ['code' => 'CAN', 'code2' => 'CA', 'name' => 'Canada', 'capital' => 'Ottawa', 'region' => 'Americas', 'subregion' => 'Northern America', 'latitude' => 45.4215, 'longitude' => -75.6919, 'currency_code' => 'CAD', 'currency_name' => 'Canadian Dollar', 'population' => 38000000, 'language' => 'English'],
            ['code' => 'KOR', 'code2' => 'KR', 'name' => 'South Korea', 'capital' => 'Seoul', 'region' => 'Asia', 'subregion' => 'Eastern Asia', 'latitude' => 37.5665, 'longitude' => 126.9780, 'currency_code' => 'KRW', 'currency_name' => 'South Korean Won', 'population' => 52000000, 'language' => 'Korean'],
            ['code' => 'SGP', 'code2' => 'SG', 'name' => 'Singapore', 'capital' => 'Singapore', 'region' => 'Asia', 'subregion' => 'South-Eastern Asia', 'latitude' => 1.3521, 'longitude' => 103.8198, 'currency_code' => 'SGD', 'currency_name' => 'Singapore Dollar', 'population' => 5900000, 'language' => 'English'],
            ['code' => 'IDN', 'code2' => 'ID', 'name' => 'Indonesia', 'capital' => 'Jakarta', 'region' => 'Asia', 'subregion' => 'South-Eastern Asia', 'latitude' => -6.2088, 'longitude' => 106.8456, 'currency_code' => 'IDR', 'currency_name' => 'Indonesian Rupiah', 'population' => 273000000, 'language' => 'Indonesian'],
            ['code' => 'MYS', 'code2' => 'MY', 'name' => 'Malaysia', 'capital' => 'Kuala Lumpur', 'region' => 'Asia', 'subregion' => 'South-Eastern Asia', 'latitude' => 3.1390, 'longitude' => 101.6869, 'currency_code' => 'MYR', 'currency_name' => 'Malaysian Ringgit', 'population' => 32000000, 'language' => 'Malay'],
            ['code' => 'THA', 'code2' => 'TH', 'name' => 'Thailand', 'capital' => 'Bangkok', 'region' => 'Asia', 'subregion' => 'South-Eastern Asia', 'latitude' => 13.7563, 'longitude' => 100.5018, 'currency_code' => 'THB', 'currency_name' => 'Thai Baht', 'population' => 70000000, 'language' => 'Thai'],
            ['code' => 'VNM', 'code2' => 'VN', 'name' => 'Vietnam', 'capital' => 'Hanoi', 'region' => 'Asia', 'subregion' => 'South-Eastern Asia', 'latitude' => 21.0278, 'longitude' => 105.8342, 'currency_code' => 'VND', 'currency_name' => 'Vietnamese Dong', 'population' => 97000000, 'language' => 'Vietnamese'],
            ['code' => 'SAU', 'code2' => 'SA', 'name' => 'Saudi Arabia', 'capital' => 'Riyadh', 'region' => 'Asia', 'subregion' => 'Western Asia', 'latitude' => 24.7136, 'longitude' => 46.6753, 'currency_code' => 'SAR', 'currency_name' => 'Saudi Riyal', 'population' => 34000000, 'language' => 'Arabic'],
            ['code' => 'ZAF', 'code2' => 'ZA', 'name' => 'South Africa', 'capital' => 'Pretoria', 'region' => 'Africa', 'subregion' => 'Southern Africa', 'latitude' => -25.7479, 'longitude' => 28.2293, 'currency_code' => 'ZAR', 'currency_name' => 'South African Rand', 'population' => 59000000, 'language' => 'Zulu'],
            ['code' => 'NLD', 'code2' => 'NL', 'name' => 'Netherlands', 'capital' => 'Amsterdam', 'region' => 'Europe', 'subregion' => 'Western Europe', 'latitude' => 52.3676, 'longitude' => 4.9041, 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'population' => 17000000, 'language' => 'Dutch'],
        ];

        foreach ($countries as $data) {
            Country::firstOrCreate(['code' => $data['code']], $data);
        }
    }
}
