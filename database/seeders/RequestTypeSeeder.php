<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      

        $types = [
            [
                'type_name' => 'إبلاغ',
                'description' => 'الإبلاغ عن مشكلة أو حالة طارئة'
            ],
            [
                'type_name' => 'تظلم',
                'description' => 'تقديم تظلم أو اعتراض رسمي'
            ],
            [
                'type_name' => 'شكوى',
                'description' => 'تقديم شكوى أو ملاحظة سلبية'
            ],
            [
                'type_name' => 'ثناء',
                'description' => 'تقديم إشادة أو تعليق إيجابي عن خدمة أو أداء'
            ],
            [
                'type_name' => 'اقتراح',
                'description' => 'تقديم فكرة أو مقترح لتحسين خدمة أو عملية معينة'
            ],
            [
                'type_name' => 'استفسار',
                'description' => 'طلب معلومات أو توضيح حول خدمة أو إجراء معين'
            ]
        ];
    
        foreach ($types as $type) {
            DB::table('request_types')->insert(array_merge($type, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
