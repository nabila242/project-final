<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Run in dependency order: countries -> ports -> lexicon -> settings -> admin user
     */
    public function run(): void
    {
        $this->call([
            CountriesSeeder::class,       // Fase 1: master data negara
            PortsSeeder::class,           // Fase 1: dataset pelabuhan (depends on countries)
            PositiveWordsSeeder::class,   // Fase 1: kamus kata positif (sentiment analysis)
            NegativeWordsSeeder::class,   // Fase 1: kamus kata negatif (sentiment analysis)
            SettingsSeeder::class,        // Fase 1: konfigurasi platform
        ]);

        // Buat akun Admin default
        User::firstOrCreate(
            ['email' => 'admin@scri.dev'],
            [
                'name'     => 'Admin SCRI',
                'password' => Hash::make('admin123'),
            ]
        );

        $this->command->info('✅ Fase 1 selesai: database seeded dengan data awal.');
    }
}
