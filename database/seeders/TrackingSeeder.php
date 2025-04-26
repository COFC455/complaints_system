<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trackings')->insert([
            'request_id' => 1,
            'updated_by' => 1,
            'request_status_id' => 1,
            'comment' => "This is a sample request description #1. " . Str::random(100),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
