<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductSeller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPrice>
 */
class ProductPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'product_seller_id' => ProductSeller::inRandomOrder()->first() ?: ProductSeller::factory(),
            'main_price' => false,
            'show_in_store' => true,
            'original_price' => rand(200, 3000) . '.00',
            'current_price' => fn (array $attr) => static::getDiscount($attr['original_price'] ?? 0, rand(10, 20)),
            'promo_price_enabled' => fake()->boolean(10),
            'promo_price' => fn (array $attr) => ($attr['promo_price_enabled'] ?? false)
                ? static::getDiscount($attr['current_price'] ?? 0, 10) : null,
            'promo_price_condition_type' => fn (array $attr) => ($attr['promo_price_enabled'] ?? false) ? 'PIX' : null,
            'promo_price_message' => fn (array $attr) => ($attr['promo_price_enabled'] ?? false)
                ? 'Pague com PIX e ganhe 10% de  desconto'
                : null,
        ];
    }

    public static function getDiscount(int|float|string $price, int|float|string $percentOfDiscount = 0): float
    {
        $price = is_numeric($price) ? floatval($price) : (float) $price;
        $percentOfDiscount = floatval($percentOfDiscount);
        $percentOfDiscount = floatval(
            str($percentOfDiscount)->replace(['-', '+', '%'], '')->trim()->toString()
        );

        return floatval($price  - (($price / 100) * $percentOfDiscount));
    }
}
