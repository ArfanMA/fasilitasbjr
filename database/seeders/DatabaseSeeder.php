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
    // Menambahkan pemanggilan AdminSeeder
    $this->call([
        AdminSeeder::class,
    ]);
}

}
