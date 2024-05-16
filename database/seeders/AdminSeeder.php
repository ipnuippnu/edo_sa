<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Muhammad Isnu Nasrudin',
            'email' => 'isnunas@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => \Str::random('10')
        ])->personal()->create([
            'gender' => 'L',
            'phone' => '6282228403855',
            'phone_verified_at' => now(),
            'born_place' => 'Trenggalek',
            'born_date' => '2001-07-08',
            'wilayah_kode' => '35.03.08.2004'
        ]);
    }
}
