<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
        [
            'name' => 'Espresso',
            'price' => 140.00,
            'subcategory_id' => 3,
            'active' => 1,
        ],
        [
            'name' => 'Nescafe',
            'price' => 180.00,
            'subcategory_id' => 3,
            'active' => 1,
        ],
        [
            'name' => 'Topla čokolada',
            'price' => 180.00,
            'subcategory_id' => 3,
            'active' => 1,
        ]]
        );
    }
}
