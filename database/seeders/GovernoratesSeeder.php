<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GovernoratesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $syrianGovernorates = [
            'دمشق',
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
            DB::table('cities')->insert([
                'city_name' => $governorate,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
