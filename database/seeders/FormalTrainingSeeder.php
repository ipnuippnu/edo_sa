<?php

namespace Database\Seeders;

use App\Models\FormalTrainingLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormalTrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
