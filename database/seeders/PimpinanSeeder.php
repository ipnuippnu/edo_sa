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
            'name' => Pimpinan::generateNameCodeFromDisplayName('PC IPNU Trenggalek', '35.03'),
        ], [
            'display_name' => 'PC IPNU Trenggalek',
            'banom' => 'IPNU',
            'address_code' => '35.03',
            'level' => 'PC',
        ]);

        Pimpinan::updateOrCreate([
            'name' => Pimpinan::generateNameCodeFromDisplayName('PC IPPNU Trenggalek', '35.03'),
        ], [
            'display_name' => 'PC IPPNU Trenggalek',
            'banom' => 'IPPNU',
            'address_code' => '35.03',
            'level' => 'PC',
        ]);
    }
}
