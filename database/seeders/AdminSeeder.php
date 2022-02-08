<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'username' => 'admin',
                'userid' => '0001',
                'email' => 'admin@kkgpaiwagir.or.id',
                'password' => Hash::make('miftahuladmin'),
                'role' => 'admin',
                'hp' => '6285850758384'
            ]
        );
    }
}
