<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('requests')->insert([
            'applicant_id' => 1,
            'category_id' => 1,
            'branch_id' => 3,
            'request_type_id' => 1,
            'request_status_id' =>1 ,
            'city_id' => 4,
            'status' => 'active',
            'description' => "This is a sample request description #1. " . Str::random(100),
            'reference_code' => 'REF-' . strtoupper(Str::random(8)) . '-1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
