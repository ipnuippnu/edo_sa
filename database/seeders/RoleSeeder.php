<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            //!!! PH (IPNU/IPPNU)
            'ph' => ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Wakil Sekretaris', 'Bendahara', 'Wakil Bendahara'],

            //!!! Departemen (IPNU/IPPNU)
            'dep' => [
                //BERSAMA
                ['Departemen Pengembangan Organisasi'],

                //IPPNU
                ['Departemen Pengembangan Organisasi dan Komisariat', 'IPPNU'],
                ['Departemen Pengembangan Komisariat', 'IPPNU'],
                ['Departemen Pendidikan, Pengkaderan dan Pengembangan SDM', 'IPPNU'],
                ['Departemen Budaya dan Olahraga', 'IPPNU'],
                ['Departemen Hubungan Pesantren dan Sosial Kemasyarakatan', 'IPPNU'],
                ['Departemen Jaringan, Komunikasi dan Informatika', 'IPPNU'],

                //IPPNU
                ['Departemen Kaderisasi', 'IPNU'],
                ['Departemen Jaringan Sekolah', 'IPNU'],
                ['Departemen Jaringan Pesantren', 'IPNU'],
                ['Departemen Jaringan Sekolah dan Pesantren', 'IPNU'],
                ['Departemen Dakwah', 'IPNU'],
                ['Departemen Olahraga, Seni dan Budaya', 'IPNU']
                
            ],

            //!!! LEMBAGA (IPNU)
            'lembaga.ipnu' => [
                'Lembaga Corp Brigade Pembangunan (CBP)' => [
                    'Komandan',
                    'Wakil Komandan',
                    'Anggota',

                    'Divisi Administrasi' => [
                        'Kepala', 'Anggota'
                    ],
                    
                    'Divisi Logistik' => [
                        'Kepala', 'Anggota'
                    ],
                    
                    'Divisi Pendidikan dan Pelatihan' => [
                        'Kepala', 'Anggota'
                    ],
                    
                    'Divisi Sosial Kemanusiaan' => [
                        'Kepala', 'Anggota'
                    ],
                ],

                'Lembaga Pers Dan Penerbitan (LPP)' => [
                    'Direktur', 'Sekretaris', 'Anggota'
                ],

                'Lembaga Ekonomi Kewirausahaan dan Koperasi (LEKAS)' => [
                    'Direktur', 'Sekretaris', 'Anggota'
                ],

                'Lembaga Anti Narkoba (LAN)' => [
                    'Direktur', 'Sekretaris', 'Anggota'
                ],

            ],

            //!!! LEMBAGA (IPPNU)
            'lembaga.ippnu' => [
                'Lembaga Korp Pelajar Putri (KPP)' => [
                    'Komandan',
                    'Sekretaris',
                    'Anggota',

                    'Bidang Kesehatan' => [
                        'Koordinator', 'Anggota'
                    ],

                    'Bidang Sosial Kemasyarakatan' => [
                        'Koordinator', 'Anggota'
                    ],

                    'Bidang Lingkungan Alam' => [
                        'Koordinator', 'Anggota'
                    ]
                ],

                'Lembaga Konseling Pelajar Putri (LKPP)' => [
                    'Koodinator', 'Anggota'
                ],

                'Lembaga Perekonomian dan Kewirausahaan (LKWU)' => [
                    'Koodinator', 'Anggota'
                ],

                'Lembaga Penelitihan dan Pengembangan (LPP)' => [
                    'Koodinator', 'Anggota'
                ],
            ],


            //!!! BADAN (IPNU)
            'badan.ipnu' => [
                'Badan Student Crisis Centre (SCC)' => [
                    'Direktur', 'Sekretaris', 'Anggota'
                ],
                'Badan Student Research Centre (SRC)' => [
                    'Direktur', 'Sekretaris', 'Anggota'
                ],
            ],
        ];

        foreach($roles as $key1 => $level1)
        {
            if($key1 === 'ph')
            {
                foreach($level1 as $role)
                {
                    $kode_me = Str::slug($role, '_');

                    $this->_exec([
                        'name' => "ph.$kode_me",
                    ],[
                        'display_name' => $role 
                    ]);
                }
            }
            else if($key1 === 'dep')
            {
                foreach($level1 as $role)
                {
                    $kode_me = Str::slug($role[0], '_');

                    $this->_exec([
                        'name' => "dep.$kode_me.co",
                    ],[
                        'display_name' => "Koordinator -- " . $role[0],
                        'banom_only' => $role[1] ?? null,
                    ]);

                    $this->_exec([
                        'name' => "dep.$kode_me.anggota",
                    ],[
                        'display_name' => "Anggota -- " . $role[0],
                        'banom_only' => $role[1] ?? null,
                    ]);
                }
            }

            else if($key1 === 'lembaga.ipnu')
            {
                foreach($level1 as $key2 => $level2)
                {
                    foreach($level2 as $key3 => $level3)
                    {
                        if(is_string($level3))
                        {
                            $kode_me = implode('.', ['lembaga', Str::slug($key2, '_'), Str::slug($level3, '_')]);
    
                            $this->_exec([
                                'name' => $kode_me,
                            ],[
                                'display_name' => "$level3 -- $key2",
                                'banom_only' => 'IPNU',
                            ]);
                        }
                        else if(is_array($level3))
                        {
                            foreach($level3 as $level4)
                            {
                                $kode_me = implode('.', ['lembaga', Str::slug($key2, '_'), Str::slug($key3, '_'), Str::slug($level4, '_')]);
    
                                $this->_exec([
                                    'name' => $kode_me,
                                ],[
                                    'display_name' => "$level4 -- $key3 -- $key2",
                                    'banom_only' => 'IPNU',
                                ]);
                            }
                        }
                    }
                }
            }
            
            else if($key1 === 'lembaga.ippnu')
            {
                foreach($level1 as $key2 => $level2)
                {
                    foreach($level2 as $key3 => $level3)
                    {
                        if(is_string($level3))
                        {
                            $kode_me = implode('.', ['lembaga', Str::slug($key2, '_'), Str::slug($level3, '_')]);
    
                            $this->_exec([
                                'name' => $kode_me,
                            ],[
                                'display_name' => "$level3 -- $key2",
                                'banom_only' => 'IPPNU',
                            ]);
                        }
                        else if(is_array($level3))
                        {
                            foreach($level3 as $level4)
                            {
                                $kode_me = implode('.', ['lembaga', Str::slug($key2, '_'), Str::slug($key3, '_'), Str::slug($level4, '_')]);

                                $this->_exec([
                                    'name' => $kode_me,
                                ],[
                                    'display_name' => "$level4 -- $key3 -- $key2",
                                    'banom_only' => 'IPPNU',
                                ]);
                            }
                        }
                    }
                }
            }

            else if($key1 === 'badan.ipnu')
            {
                foreach($level1 as $key2 => $level2)
                {
                    foreach($level2 as $key3 => $level3)
                    {
                        $kode_me = implode('.', ['badan', Str::slug($key2, '_'), Str::slug($level3, '_')]);

                        $this->_exec([
                            'name' => $kode_me
                        ], [
                            'display_name' => "$level3 -- $key2",
                            'banom_only' => 'IPNU',
                        ]);
                    }
                }
            }

            else if($key1 === 'badan.ippnu')
            {
                foreach($level1 as $key2 => $level2)
                {
                    foreach($level2 as $key3 => $level3)
                    {
                        $kode_me = implode('.', ['badan', Str::slug($key2, '_'), Str::slug($level3, '_')]);

                        $this->_exec([
                            'name' => $kode_me,
                        ],[
                            'display_name' => "$level3 -- $key2",
                            'banom_only' => 'IPPNU',
                        ]);
                    }
                }
            }
        }
    }

    private function _exec(array $first, array $second)
    {
        Role::updateOrCreate($first, $second);
    }
}