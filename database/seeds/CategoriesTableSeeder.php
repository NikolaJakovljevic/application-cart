<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'parent_id' => 0,
            'name' => 'Piće',
            'slug' => 'pice'
        ]);

        DB::table('categories')->insert([
            'parent_id' => 0,
            'name' => 'Hrana',
            'slug' => 'hrana'
        ]);

        DB::table('categories')->insert([
            'parent_id' => 1,
            'name' => 'Kafe i topli napici',
            'slug' => 'kafe-i-topli-napici'
        ]);

        DB::table('categories')->insert([
            'parent_id' => 1,
            'name' => 'Sokovi',
            'slug' => 'sokovi'
        ]);
    }
}
