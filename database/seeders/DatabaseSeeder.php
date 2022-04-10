<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ReferenceSeeder::class,
            AdminSeeder::class,
            DummySeeder::class
            // UserSeeder::class,
            // UserDetailSeeder::class,
            // LeaveDetailSeeder::class,
        ]);
    }
}
