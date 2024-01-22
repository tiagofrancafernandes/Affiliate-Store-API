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
        Schema::create('product_sellers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable()->index();
            $table->string('icon_url')->nullable(); // Icon URL
            $table->longText('base64_icon')->nullable(); // base64 icon

            /**
             * Default affiliate page (when user want to see all in refered)
             */
            $table->string('default_affiliate_page')->nullable();

            /**
             * If seller page can be opened
             */
            $table->boolean('show_default_affiliate_page')->default(true)->nullable();

            /**
             * Featured links on top of page
             * [{"label": "...", "url": "https://...", "show": "top|bottom|all|none|null"}]
             */
            $table->json('page_direct_links')->nullable();

            /**
             * Text, presentationa and more when user open it
             */
            $table->longText('page_content')->nullable();

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
        Schema::dropIfExists('product_sellers');
    }
};
