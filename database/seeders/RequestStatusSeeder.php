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


        $statuses = [
            [
                'status_name' => 'قيد المعالجة',
                'description' => 'الحالة الافتراضية للطلب عند إنشائه'
            ],
            [
                'status_name' => 'تم الحل',
                'description' => 'تم حل الطلب بشكل كامل'
            ],
            [
                'status_name' => 'عاجلة',
                'description' => 'حالات تحتاج تدخل فوري'
            ],
            [
                'status_name' => 'قيد الانتظار',
                'description' => 'في انتظار معلومات إضافية'
            ],
            [
                'status_name' => 'متوقفة',
                'description' => 'تم إيقاف العمل على الطلب مؤقتًا'
            ],
            [
                'status_name' => 'ملغية',
                'description' => 'تم إلغاء الطلب نهائيًا'
            ]
        ];
        
        foreach ($statuses as $status) {
            DB::table('request_statuses')->insert([
                'status_name' => $status['status_name'],
                'description' => $status['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
