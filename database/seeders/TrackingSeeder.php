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
        $trackings = [];
        for ($i = 1; $i <= 5; $i++) {
            $trackings[] = [
                'request_id' => rand(1, 5),
                'updated_by' => rand(1, 1),
                'request_status_id' => DB::table('request_statuses')->inRandomOrder()->first()->id,
                'comment' => "تحديث حالة الطلب #$i - " . Str::random(100),
                'created_at' => now()->subHours(rand(1, 24 * 7)), // تواريخ خلال أسبوع
                'updated_at' => now(),
            ];
        }
        
        DB::table('trackings')->insert($trackings);
    }
}
