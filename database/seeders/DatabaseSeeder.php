<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        require __DIR__ . '/UserRolePermissionSeeder.php';
        require __DIR__ . '/JobPostingSeeder.php';
        require __DIR__ . '/DivisionSeeder.php';
        require __DIR__ . '/PositionSeeder.php';
        
    }
}
