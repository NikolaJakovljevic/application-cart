<?php

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
        DB::table('users')->insert([
            'name' => 'Milica',
            'email' => 'mirkovicmilica@hotmail.com',
            'password' => bcrypt('milica123'),
        ]);
    }
}
