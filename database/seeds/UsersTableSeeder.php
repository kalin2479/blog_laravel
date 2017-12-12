<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::truncate(); //vaciamos la tabla

      $user = new User;
      $user->name = 'Carlos Espinoza';
      $user->email = 'carlos.espinoza24g@gmail.com';
      $user->password = bcrypt('123123');
      $user->save();
    }
}
