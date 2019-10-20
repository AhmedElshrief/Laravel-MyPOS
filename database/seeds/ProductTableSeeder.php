<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = ['product one', 'product two'];

        foreach ($products as $product) {
            Product::create([

                'category_id' => 1,
                'ar' => ['name' => $product, 'description' => $product.' desc'],
                'en' => ['name' => $product, 'description' => $product.' desc'],
                'buy_price' => 100,
                'sale_price' => 150,
                'stock' => 100,
            ]);

        }//end of foreach

    }//end of run

}//end of class
