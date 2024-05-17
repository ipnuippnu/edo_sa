<?php

namespace App\Console\Commands;

use App\Models\Pimpinan;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mpyw\UuidUlidConverter\Converter;

class ImportUsersFromOld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:old-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrasi data user lama';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // dd(Role::first(), Pimpinan::first());
        if(!Storage::exists('users.json')) throw new \Exception("Berkas " . Storage::path('users.json') . " tidak ditemukan");

        DB::transaction(function(){
            $users = collect(json_decode(Storage::get('users.json')));
        
            $users->sortBy(['created_at', 'address_code'])->filter(fn($data) => is_null($data->deleted_at))->each(function($user){

                preg_match("/^(?P<level>PC|PAC|PK|PR) (?P<banom>IPNU|IPPNU) (?P<name>.*)$/", $user->name, $names);

                Pimpinan::updateOrCreate([
                    'name'          =>  Pimpinan::generateNameCodeFromDisplayName($user->name, $user->address_code)
                ],[
                    'ulid'          =>  Converter::uuidToUlid($user->id),
                    'display_name'  =>  $user->name,
                    'address_code'  =>  $user->address_code,
                    'level'         =>  $names['level'],
                    'banom'         =>  $names['banom'],
                    'created_at'    =>  $user->created_at,
                    'updated_at'    =>  Carbon::now()
                ]);
            });

        });
    }
}
