<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
          'المدير العام',
          'مدير الفرع',
          'مدير العلاقات العامة',
          'الدائرة المركزية',
          'وكيل اقتصادي',
          'وكيل إداري',
          'وكيل تحقيق',
          'وكيل تأشير'
        ];

      foreach ($roles as $role) {
            DB::table('roles')->insert([
                'role_name' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
