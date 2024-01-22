<?php

namespace App\Models;

use App\Models\Traits\RecordHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property-read string $singleItemCacheKey
 */
class ProductPrice extends Model
{
    use HasFactory;
    use SoftDeletes;
    use RecordHelpers;
    // use Traits\OnlyTenantScopeTrait; // Only Tenant
    // use Traits\OnlyGlobalScopeTrait; // Only Global (not tenant)

    // public $table = '';

    protected $fillable = [
        'product_id',
        'product_seller_id',
        'show_in_store',
        'main_price',
        'original_price',
        'current_price',
        'promo_price',
        'promo_price_enabled',
        'promo_price_condition_type',
        'promo_price_message',
    ];

    protected $casts = [
        'show_in_store' => 'boolean',
        'main_price' => 'boolean',
        'promo_price_enabled' => 'boolean',
    ];

    protected $appends = [
        //
    ];

    /**
     * Get the product that owns the ProductPrice
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the seller that owns the ProductPrice
     *
     * @return BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(ProductSeller::class);
    }
}
