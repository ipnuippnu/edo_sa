<?php

namespace Database\Seeders;

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
        $this->call([
            WilayahSeeder::class,
            FormalTrainingSeeder::class,
            TrainingSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
        ]);

    }
}
