<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reports')->insert([
            'generated_by' => 1,
            'report_type'  => 'type1',
            'data' => json_encode(['Name' => 'sola']),
            'created_at' => now(),
            'updated_at' => now()
        ]);
}
}
