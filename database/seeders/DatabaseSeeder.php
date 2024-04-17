<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //App\Models\User::factory(10)->create();

        Model::unguard(); // Disable mass assignment

        $this->call(RoleSeeder::class);

        //$this->call(DummyDataSeeder::class);

        Model::reguard(); // Enable mass assignment
    }
}
