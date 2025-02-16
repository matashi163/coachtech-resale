<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_categories = [
            [
                'product_id' => '1',
                'category_id' => '1',
            ],[
                'product_id' => '1',
                'category_id' => '5',
            ],[
                'product_id' => '1',
                'category_id' => '12',
            ],[
                'product_id' => '2',
                'category_id' => '8',
            ],[
                'product_id' => '3',
                'category_id' => '10',
            ],[
                'product_id' => '4',
                'category_id' => '1',
            ],[
                'product_id' => '4',
                'category_id' => '5',
            ],[
                'product_id' => '5',
                'category_id' => '8',
            ],[
                'product_id' => '7',
                'category_id' => '1',
            ],[
                'product_id' => '7',
                'category_id' => '4',
            ],[
                'product_id' => '8',
                'category_id' => '10',
            ],[
                'product_id' => '9',
                'category_id' => '10',
            ],[
                'product_id' => '10',
                'category_id' => '6',
            ],
        ];

        ProductCategory::insert($product_categories);
    }
}
