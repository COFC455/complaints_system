<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('request_statuses')->insert([
            'status_name' => 'Resolved',
            'description'  => 'Lorem ipsum is a dummy or placeholder text commonly used in graphic design, publishing, and web development',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
