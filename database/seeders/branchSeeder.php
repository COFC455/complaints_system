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
            'دمشق',
            'ريف دمشق',
            'اللاذقية',
            'حماة',
            'طرطوس',
            'دير الزور',
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
