<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wilayah::truncate();
        DB::unprepared(file_get_contents(database_path('wilayah.sql')));
    }
}
