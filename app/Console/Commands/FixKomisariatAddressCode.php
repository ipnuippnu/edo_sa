<?php

namespace App\Console\Commands;

use App\Helpers\Tulisan;
use App\Models\Pimpinan;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FixKomisariatAddressCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:komisariat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Pimpinan::withTrashed()->whereLevel('PK')->get()->groupBy(fn(Pimpinan $pimpinan) => $pimpinan->banom .'_'. $pimpinan->parent->kode)->each(function(Collection $pimpinans){

            $pimpinans->each(function(Pimpinan $pimpinan, $index){

                $pimpinan->update([
                    'address_code' => $pimpinan->parent->kode .".". Tulisan::padLeft(++$index, 4, 'K000')
                ]);
            });

        });
    }
}
