<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;
use App\Models\Country;

class PortsSeeder extends Seeder
{
    public function run(): void
    {
        // Sample dataset from World Port Index (major ports globally)
        // In production: import full CSV via this seeder pattern
        $ports = [
            ['wpi_number' => '56020', 'name' => 'Port of Shanghai', 'country_code' => 'CHN', 'latitude' => 31.2304, 'longitude' => 121.4737, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '56030', 'name' => 'Port of Ningbo-Zhoushan', 'country_code' => 'CHN', 'latitude' => 29.8683, 'longitude' => 121.5440, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '57021', 'name' => 'Port of Singapore', 'country_code' => 'SGP', 'latitude' => 1.2897, 'longitude' => 103.8501, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '48430', 'name' => 'Port of Rotterdam', 'country_code' => 'NLD', 'latitude' => 51.9225, 'longitude' => 4.4792, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '56240', 'name' => 'Port of Guangzhou (Nansha)', 'country_code' => 'CHN', 'latitude' => 22.7522, 'longitude' => 113.6253, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '56120', 'name' => 'Port of Qingdao', 'country_code' => 'CHN', 'latitude' => 36.0786, 'longitude' => 120.3719, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '56110', 'name' => 'Port of Tianjin', 'country_code' => 'CHN', 'latitude' => 38.9927, 'longitude' => 117.7219, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '56050', 'name' => 'Port of Shenzhen', 'country_code' => 'CHN', 'latitude' => 22.5431, 'longitude' => 113.9288, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '57030', 'name' => 'Port of Busan', 'country_code' => 'KOR', 'latitude' => 35.1796, 'longitude' => 129.0756, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '16680', 'name' => 'Port of Los Angeles', 'country_code' => 'USA', 'latitude' => 33.7395, 'longitude' => -118.2652, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '16690', 'name' => 'Port of Long Beach', 'country_code' => 'USA', 'latitude' => 33.7701, 'longitude' => -118.1937, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '53630', 'name' => 'Port of Antwerp', 'country_code' => 'DEU', 'latitude' => 51.2194, 'longitude' => 4.4025, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '49450', 'name' => 'Port of Hamburg', 'country_code' => 'DEU', 'latitude' => 53.5753, 'longitude' => 9.9644, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '57101', 'name' => 'Port of Tanjung Pelepas', 'country_code' => 'MYS', 'latitude' => 1.3614, 'longitude' => 103.5519, 'harbor_type' => 'CN', 'harbor_size' => 'L'],
            ['wpi_number' => '57290', 'name' => 'Port of Tanjung Priok (Jakarta)', 'country_code' => 'IDN', 'latitude' => -6.1059, 'longitude' => 106.8810, 'harbor_type' => 'CN', 'harbor_size' => 'L'],
            ['wpi_number' => '57261', 'name' => 'Port of Laem Chabang', 'country_code' => 'THA', 'latitude' => 13.0836, 'longitude' => 100.8802, 'harbor_type' => 'CN', 'harbor_size' => 'L'],
            ['wpi_number' => '57401', 'name' => 'Port of Ho Chi Minh City', 'country_code' => 'VNM', 'latitude' => 10.7769, 'longitude' => 106.7009, 'harbor_type' => 'CN', 'harbor_size' => 'L'],
            ['wpi_number' => '57045', 'name' => 'Port of Yokohama', 'country_code' => 'JPN', 'latitude' => 35.4437, 'longitude' => 139.6380, 'harbor_type' => 'CN', 'harbor_size' => 'V'],
            ['wpi_number' => '54810', 'name' => 'Port of Mumbai (JNPT)', 'country_code' => 'IND', 'latitude' => 18.9488, 'longitude' => 72.9310, 'harbor_type' => 'CN', 'harbor_size' => 'L'],
            ['wpi_number' => '40210', 'name' => 'Port of Durban', 'country_code' => 'ZAF', 'latitude' => -29.8587, 'longitude' => 31.0218, 'harbor_type' => 'CN', 'harbor_size' => 'L'],
        ];

        foreach ($ports as $portData) {
            $country = Country::where('code', $portData['country_code'])->first();
            Port::firstOrCreate(
                ['wpi_number' => $portData['wpi_number']],
                array_merge($portData, ['country_id' => $country?->id])
            );
        }
    }
}
