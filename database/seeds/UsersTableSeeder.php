<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'Andrei Walber',
            'email'    => 'andreiwalber@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name'     => 'Usuario Dois',
            'email'    => 'usuario.dois@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
