<?php

use Illuminate\Database\Seeder;

class TablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 9; $i++){
            DB::table('tables')->insert([
                'name' => $i,
                'number' => $i,
                'active' => 1
            ]);
        }
    }
}
