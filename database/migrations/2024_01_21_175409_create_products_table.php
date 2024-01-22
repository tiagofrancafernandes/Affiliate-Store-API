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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('small_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->json('images')->nullable();
            $table->boolean('featured')->nullable()->index();
            $table->string('review_rating')->nullable()->index();
            $table->boolean('show_review_rating')->default(true)->nullable()->index();
            $table->boolean('show_in_store')->nullable()->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['created_at']);
            $table->index(['updated_at']);
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
