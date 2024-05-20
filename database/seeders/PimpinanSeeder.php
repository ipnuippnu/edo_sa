<?php

namespace Database\Seeders;

use App\Models\Pimpinan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PimpinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pimpinan::updateOrCreate([
            'name' => 'PC IPNU Trenggalek',
            'address_code' => '35.03',
        ], [
            'banom' => 'IPNU',
            'level' => 'PC',
        ]);

        Pimpinan::updateOrCreate([
            'name' => 'PC IPPNU Trenggalek',
            'address_code' => '35.03',
        ], [
            'banom' => 'IPPNU',
            'level' => 'PC',
        ]);
    }
}
