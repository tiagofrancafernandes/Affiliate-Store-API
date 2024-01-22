<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // https://flowbite.com/docs/images/products/apple-watch.png

        return [
            'name' => 'Product ' . fake()->words(2, true),
            'small_description' => fake()->words(10, true),
            'long_description' => collect(fake()->paragraphs(3))
                ->map(fn ($p) => htmlentities('<p>' . $p . '</p>'))->implode(PHP_EOL),
            'images' => [
                [
                    'url' => 'https://via.placeholder.com/899x567.png?text=' . urlencode(
                        $alt = implode(PHP_EOL, [
                            'Picture #1',
                            '',
                            '',
                            '899x567',
                        ])
                    ),
                    'alt' => str_replace(PHP_EOL, ' ', $alt),
                ],
                [
                    'url' => 'https://via.placeholder.com/899x567.png?text=' . urlencode(
                        $alt = implode(PHP_EOL, [
                            'Picture #2',
                            '',
                            '',
                            '899x567',
                        ])
                    ),
                    'alt' => str_replace(PHP_EOL, ' ', $alt),
                ],
                [
                    'url' => 'https://via.placeholder.com/899x567.png?text=' . urlencode(
                        $alt = implode(PHP_EOL, [
                            'Picture #3',
                            '',
                            '',
                            '899x567',
                        ])
                    ),
                    'alt' => str_replace(PHP_EOL, ' ', $alt),
                ],
                [
                    'url' => 'https://via.placeholder.com/899x567.png?text=' . urlencode(
                        $alt = implode(PHP_EOL, [
                            'Picture #4',
                            '',
                            '',
                            '899x567',
                        ])
                    ),
                    'alt' => str_replace(PHP_EOL, ' ', $alt),
                ],
            ],
            'featured' => fake()->boolean(10),
            'show_review_rating' => fake()->boolean(80),
            'review_rating' => fn ($attr) => ($attr['show_review_rating'] ?? null) ? (fake()->regexify('[1-5]\.[05]')) : null ,
        ];
    }
}
