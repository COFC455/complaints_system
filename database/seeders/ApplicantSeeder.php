<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('applicants')->insert([
            [
                'full_name' => 'أحمد محمد علي',
                'email' => 'ahmed.ali@example.com',
                'phone' => '2344444',
                'mobile_phone' => '0935111222',
                'national_id' => '12345678912',
                'address' => 'دوما - دمشق',
                'created_at' => '2023-01-10',
                'updated_at' => '2023-01-10'
            ],
            [
                'full_name' => 'سمر خالد حسن',
                'email' => 'samer.hassan@example.com',
                'phone' => '2367444',
                'mobile_phone' => '0944222333',
                'national_id' => '98765432112',
                'address' => 'حلب - السلمانية',
                'created_at' => '2023-02-15',
                'updated_at' => '2023-02-15'
            ],
            [
                'full_name' => 'ليلى ناصر الديري',
                'email' => 'layila.dwaire@gmail.com',
                'phone' => '2338974',
                'mobile_phone' => '0955333444',
                'national_id' => '45612378965',
                'address' => 'حمص - الزهراء',
                'created_at' => '2023-03-20',
                'updated_at' => '2023-03-20'
            ],
            [
                'full_name' => 'ياسر سعد القادري',
                'email' => 'yasser.alkaderi@example.com',
                'phone' => '9876543',
                'mobile_phone' => '0966444555',
                'national_id' => '78912345698',
                'address' => 'اللاذقية - الرمل الشمالي',
                'created_at' => '2023-04-05',
                'updated_at' => '2023-04-05'
            ],
            [
                'full_name' => 'هناء عمر العموي',
                'email' => 'hana.hamwi@example.com',
                'phone' => '9876543',
                'mobile_phone' => '0937555666',
                'national_id' => '32165498734',
                'address' => 'حماه - النصر',
                'created_at' => '2023-05-12',
                'updated_at' => '2023-05-12'
            ],
            // البيانات الجديدة المطلوبة
            [
                'full_name' => 'Ahmad J Sy',
                'email' => 'ahmad@gmail.com',
                'phone' => '2344444',
                'mobile_phone' => '0939733456',
                'national_id' => '06050087551',
                'address' => 'دمشق- المحافظة',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

} 

