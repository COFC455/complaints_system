<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // بيانات الحسابات المطلوبة (اقتصادي، تنمية، تأشير)
            $usersData = [

                [
                    'name' => 'الإدارة المركزية ',
                    'email' => 'admin@example.com',
                    'role_id' => 1, // تأكد من تطابق role_id مع جدول الأدوار
                    'phone' => '0938733457',
                    'branch_id' => 1,
                ],

                [
                    'name' => 'الوكيل الاقتصادي',
                    'email' => 'economic@example.com',
                    'role_id' => 5, // تأكد من تطابق role_id مع جدول الأدوار
                    'phone' => '0938733457',
                    'branch_id' => 4,
                ],
                [
                    'name' => 'الوكيل الإداري',
                    'email' => 'managerial@example.com',
                    'role_id' => 6,
                    'phone' => '0938733458',
                    'branch_id' => 3,
                ],
                [
                    'name' => 'وكيل التأشير ',
                    'email' => 'signing@example.com',
                    'role_id' => 8,
                    'phone' => '0938733459',
                    'branch_id' => 2,
                ],
                  [
                    'name' => 'وكيل التحقيق',
                    'email' => 'investigator@example.com',
                    'role_id' => 7,
                    'phone' => '0938733459',
                    'branch_id' => 1,
                ]
            ];

            // القيم الثابتة لجميع الحسابات
            $commonData = [
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ];

        // إنشاء الحسابات باستخدام الحلقة
        foreach ($usersData as $user) {
            DB::table('users')->insert(array_merge($user, $commonData));
        }

        }
}
