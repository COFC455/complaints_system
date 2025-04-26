<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('applicants')->insert([

            'full_name' => 'Ahmad J Sy',
            'email' => 'ahmad@gmail.com',
            'phone' => '234 444 4',
            'mobile_phone' => '0939733456',
            'national_id'   => '0605008755',
            'address'  => '29 Aear Damascus',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
