<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
        [    
            'name' => 'Sample',
            'email' => 'sample@gmail.com',
            'password' => Hash::make('Sample123'),
        ],
        [    
            'name' => 'Sample2',
            'email' => 'sample2@gmail.com',
            'password' => Hash::make('Sample2123'),
        ],
    ]);
    }
}
