<?php

namespace App\Console\Commands;

use App\Enums\JabatanStatus;
use App\Models\Pimpinan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        if(!Storage::exists('users.json')) throw new \Exception("Berkas " . Storage::path('users.json') . " tidak ditemukan");

        DB::transaction(function(){
            $users = collect(json_decode(Storage::get('users.json')));
        
            $users->sortBy(['created_at', 'address_code'])->filter(fn($data) => is_null($data->deleted_at))->each(function($user){

                preg_match("/^(?P<level>PC|PAC|PK|PR) (?P<banom>IPNU|IPPNU) (?P<name>.*)$/", $user->name, $names);

                extract($names);

                $pimpinan = Pimpinan::updateOrCreate([
                    'name'  =>  $user->name,
                    'address_code'  =>  $user->address_code,
                ],[
                    // 'ulid'          =>  Converter::uuidToUlid($user->id),
                    'level'         =>  $level,
                    'banom'         =>  $banom,
                ]);
                

            })->each(function($old){
                
                preg_match("/^(?P<level>PC|PAC|PK|PR) (?P<banom>IPNU|IPPNU) (?P<name>.*)$/", $old->name, $names);

                extract($names);

                DB::beginTransaction();

                if($names['banom'] === 'IPPNU' && $level !== 'PC')
                {

                    //!!! PASSWORD DARI IPPNU
                    $user = User::create([
                        'name' => "Admin $level $name",
                        'password' => $old->password,
                        'account_type' => 2,
                        'email' => str_replace('@ippnu.', '@', $old->email),
                        'email_verified_at' => Carbon::now(),
                        'created_at'    =>  $old->created_at,
                        'updated_at'    =>  Carbon::now(),
                        'first_login_at' => $old->first_login,
                        'last_login_at' => $old->last_login,
                        'remember_token' => $old->remember_token
                    ]);

                    Pimpinan::whereAddressCode($old->address_code)->where('name', 'LIKE', "$level%")->where('name', 'LIKE', "%$name")->get()->each(function ($pimpinan) use($user) {

                        $user->tambahJabatan('operator', $pimpinan, [
                            'status' => JabatanStatus::AKTIF,
                            'confirmed_at' => Carbon::now(),
                        ]);

                    });

                }

                DB::commit();

            });

        });
    }
}
