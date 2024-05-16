<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainings = [
            [
                'is_formal' => false,
                'name' => 'Kongkow Media',
                'pelaksana' => 'PAC IPNU-IPPNU Watulimo',
                'year' => 2024
            ],
            [
                'is_formal' => false,
                'name' => 'Kongkow Jurnalistik',
                'pelaksana' => 'PAC IPNU-IPPNU Watulimo',
                'year' => 2021
            ],
        ];

        foreach($trainings as $training)
        {
            Training::firstOrCreate($training);
        }
    }
}
