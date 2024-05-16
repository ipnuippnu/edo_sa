<?php

namespace Database\Seeders;

use App\Models\FormalTrainingLevel;
use App\Models\User;
use App\Models\Wilayah;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Wilayah::truncate();
        DB::unprepared(file_get_contents(database_path('wilayah.sql')));

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

        $formal_trainings = [
            ['name' => 'MAKESTA', 'fullname' => 'Masa Kesetiaan Anggota', 'pelaksana' => 'IPNU/IPPNU'],
            ['name' => 'LAKMUD', 'fullname' => 'Latihan Kader Muda', 'pelaksana' => 'IPNU/IPPNU'],
            ['name' => 'LAKUT', 'fullname' => 'Latihan Kader Utama', 'pelaksana' => 'IPNU/IPPNU'],
            ['name' => 'LAKNAS', 'fullname' => 'Latihan Kader Nasional', 'pelaksana' => 'IPNU/IPPNU'],

            ['name' => 'LATIN 1', 'fullname' => 'Latihan Instruktur 1', 'pelaksana' => 'IPNU'],
            ['name' => 'LATIN 2', 'fullname' => 'Latihan Instruktur 2', 'pelaksana' => 'IPNU'],
            ['name' => 'LATINAS', 'fullname' => 'Latihan Instruktur Nasional', 'pelaksana' => 'IPNU'],

            ['name' => 'LATPEL 1', 'fullname' => 'Latihan Pelatih 1', 'pelaksana' => 'IPPNU'],
            ['name' => 'LATPEL 2', 'fullname' => 'Latihan Pelatih 2', 'pelaksana' => 'IPPNU'],
            ['name' => 'LATPELNAS', 'fullname' => 'Latihan Pelatih Nasional', 'pelaksana' => 'IPPNU'],

            ['name' => 'DIKLATAMA', 'fullname' => 'Pendidikan dan Pelatihan Pertama', 'pelaksana' => 'CBP-KPP'],
            ['name' => 'DIKLATMAD', 'fullname' => 'Pendidikan dan Pelatihan Madya', 'pelaksana' => 'CBP-KPP'],
            ['name' => 'DIKLATNAS', 'fullname' => 'Pendidikan dan Pelatihan Nasional', 'pelaksana' => 'CBP-KPP'],
            ['name' => 'DIKLATPEL', 'fullname' => 'Pendidikan dan Pelatihan Pelatihan', 'pelaksana' => 'CBP-KPP'],
        ];

        foreach($formal_trainings as $pengkaderan)
        {
            FormalTrainingLevel::updateOrCreate(['name' => $pengkaderan['name']], $pengkaderan);
        }

    }
}
