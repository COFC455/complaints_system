<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      $this->call([
        RoleSeeder::class,
        branchSeeder::class,
        UserSeeder::class,
        GovernoratesSeeder::class,
        ApplicantSeeder::class,
        CategorySeeder::class,
        RequestTypeSeeder::class,
        RequestStatusSeeder::class,
        ReportSeeder::class,
        RequestsTableSeeder::class,
        TrackingSeeder::class,

      ]);
    }
}
