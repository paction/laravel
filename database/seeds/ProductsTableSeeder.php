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
        factory(App\Products::class, 16)->create()->each(function($p) {
            for ($i = 0; $i < 6; $i++) {
                $p->images()->save(factory(App\ProductImages::class)->make());
            }
            
            for ($i = 0; $i < 5; $i++) {
                $p->options()->save(factory(App\ProductOptions::class)->make());
            }
        });
    }
}
