<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'مشاكل مالية',
               'description' => 'قضايا متعلقة بالمعاملات المالية، التأخير في الصرفيات، أو مشاكل الرواتب'
            ],
            [
                'category_name' => 'اختلاس',
                'description' => 'حالات سوء استخدام الأموال أو الموارد المالية بشكل غير مشروع'
            ],
    
        ];
        
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'category_name' => $category['category_name'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
}
}