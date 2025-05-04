<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class branchSeeder extends Seeder
{
    /**
     * قم بتشغيل السيدر
     */
    public function run(): void
    {
        $syrianGovernorates = [
            'دمشق-الفرع الرئيسي',
            'دمشق-التأشير',
            'دمشق-الإداري',
            'دمشق-الإقتصادي',
            'ريف دمشق',
            'حلب',
            'حمص',
            'اللاذقية',
            'حماة',
            'طرطوس',
            'دير الزور',
            'الحسكة',
            'الرقة',
            'إدلب',
            'السويداء',
            'درعا',
            'القنيطرة'
        ];


        foreach ($syrianGovernorates as $governorate) {
            DB::table('branches')->insert([
                'branch_name' => $governorate,
                'location'    => 'not defined',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
