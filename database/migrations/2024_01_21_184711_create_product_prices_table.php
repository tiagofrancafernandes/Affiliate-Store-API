<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('product_seller_id')->index();

            $table->boolean('show_in_store')->nullable()->default(true)->index();
            $table->boolean('main_price')->nullable()->default(false)->index();
            $table->string('original_price')->nullable()->index();
            $table->string('current_price')->nullable()->index();
            $table->string('promo_price')->nullable()->index();
            $table->boolean('promo_price_enabled')->nullable()->index();
            $table->string('promo_price_condition_type')->nullable()->index(); // Enum: PIX, CreditCard, Money, ...
            $table->string('promo_price_message')->nullable(); // For payment in ...

            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at']);
            $table->index(['updated_at']);
            $table->index(['deleted_at']);
            $table->foreign('product_id')->references('id')
                ->on('products')->onDelete('cascade'); // cascade|set null

            $table->foreign('product_seller_id')->references('id')
                ->on('product_sellers')->onDelete('cascade'); // cascade|set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
