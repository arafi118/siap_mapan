<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Family;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Business::factory()->has(User::factory()->count(3))->create();
        Customer::factory()->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    Family::create([
        'kekeluargaan' => 'Suami'
    ]);
    Family::create([
        'kekeluargaan' => 'Istri'
    ]);
    Family::create([
        'kekeluargaan' => 'Ayah'
    ]);
    Family::create([
        'kekeluargaan' => 'Ibu'
    ]);
    Family::create([
        'kekeluargaan' => 'Sdr. Kandung'
    ]);
    Family::create([
        'kekeluargaan' => 'Anak'
    ]);
    Family::create([
        'kekeluargaan' => 'Kerabat Lainya'
    ]);
    Family::create([
        'kekeluargaan' => 'Ketua Kelompok'
    ]);
    Village::create([
        'nama' => 'Sutopati',
        'kode' => '123'
    ]);
    Village::create([
        'nama' => 'Kajoran',
        'kode' => '124'
    ]);
    Village::create([
        'nama' => 'Salaman',
        'kode' => '125'
    ]);
    }
}
