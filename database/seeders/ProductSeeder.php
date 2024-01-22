<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductSeller;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ProductSeller::count() <= 3) {
            ProductSeller::factory(6)->create();
        }

        Product::factory(30)
            // ->has(ProductPrice::factory(rand(1, 3)), 'priceList')
            ->create()
            ->each(
                fn (Product $product) => $product->priceList()->saveMany(
                    ProductPrice::factory(rand(1, 3))->create()
                )
            );
    }
}
