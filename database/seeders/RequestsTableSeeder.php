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

       $requests = [];
for ($i = 1; $i <= 5; $i++) {
    $requests[] = [
        'applicant_id' => rand(1, 5), // فرضًا أن لديك 5 مقدمي طلبات
        'category_id' => rand(1, 2), // فرضًا أن لديك 3 تصنيفات
        'branch_id' => rand(1, 5), // فروع افتراضية
        'request_type_id' => rand(1, 4), // أنواع الطلبات
        'request_status_id' => rand(1, 3), // حالات الطلب
        'city_id' => rand(1, 5), // مدن افتراضية
        'user_id' => rand(1, 5), 
        'status' => 'active',
        'description' => "وصف الطلب رقم #$i - " . Str::random(100),
        'reference_code' => 'REF-' . strtoupper(Str::random(8)) . "-$i",
        'created_at' => now()->subDays(rand(1, 30)), // تواريخ عشوائية خلال آخر 30 يوم
        'updated_at' => now(),
    ];
}

        DB::table('requests')->insert($requests);
    }
}
