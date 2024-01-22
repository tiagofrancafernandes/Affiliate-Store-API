<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSeller>
 */
class ProductSellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'slug' => fn ($attr) => str(uniqid())->append(' ')->append($attr['name'] ?? null)->slug(),
            'base64_icon' => $base64Icon = 'PHN2ZyBjbGFzcz0idy02NCBoLTY0IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iY3VycmVudENvbG9yIiB2aWV3Qm94PSIwIDAgMTYgMTYiPiA8cGF0aCBkPSJNMTUgLjVhLjUuNSAwIDAgMC0uNzI0LS40NDdsLTggNEEuNS41IDAgMCAwIDYgNC41djMuMTRMLjM0MiA5LjUyNkEuNS41IDAgMCAwIDAgMTB2NS41YS41LjUgMCAwIDAgLjUuNWg5YS41LjUgMCAwIDAgLjUtLjVWMTRoMXYxLjVhLjUuNSAwIDAgMCAuNS41aDNhLjUuNSAwIDAgMCAuNS0uNVYuNVpNMiAxMWgxdjFIMnYtMVptMiAwaDF2MUg0di0xWm0tMSAydjFIMnYtMWgxWm0xIDBoMXYxSDR2LTFabTktMTB2MWgtMVYzaDFaTTggNWgxdjFIOFY1Wm0xIDJ2MUg4VjdoMVpNOCA5aDF2MUg4VjlabTIgMGgxdjFoLTFWOVptLTEgMnYxSDh2LTFoMVptMSAwaDF2MWgtMXYtMVptMy0ydjFoLTFWOWgxWm0tMSAyaDF2MWgtMXYtMVptLTItNGgxdjFoLTFWN1ptMyAwdjFoLTFWN2gxWm0tMi0ydjFoLTFWNWgxWm0xIDBoMXYxaC0xVjVaIj48L3BhdGg+IDwvc3ZnPg==',
            'icon_url' => 'data:image/svg+xml;base64,' . $base64Icon,
            'default_affiliate_page' => 'https://bigstore.com/aff/john-doe',
            'show_default_affiliate_page' => true,

            'page_content' => collect(fake()->paragraphs(3))
                ->map(fn ($p) => htmlentities('<p>' . $p . '</p>'))->implode(PHP_EOL),

            /**
             * Featured links on top of page
             * [{"label": "...", "url": "https://...", "show": "top|bottom|all|none|null"}]
             */
            'page_direct_links' => collect(range(1, 5))->map(fn ($item) => [
                'label' => fake()->words(3, true),
                'url' => fake()->url(),
                'class' => 'my-class item-' . $item,
                'show' => \Arr::random([
                    'top',
                    'bottom',
                    'all',
                    'none',
                    null,
                ])
            ]),
        ];
    }
}
