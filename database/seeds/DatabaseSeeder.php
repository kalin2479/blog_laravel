<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Esta funcion sirve para llenar de manera automatica
        // $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
    }
}
