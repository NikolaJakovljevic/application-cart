<?php

use Illuminate\Database\Seeder;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insert([
                [
                    'name' => '5%',
                    'value' => 0.05,
                    'active' => 1,
                ],
                [
                    'name' => '10%',
                    'value' => 0.1,
                    'active' => 1,
                ],
                [
                    'name' => '15%',
                    'value' => 0.15,
                    'active' => 1,
                ]]
        );
    }
}
