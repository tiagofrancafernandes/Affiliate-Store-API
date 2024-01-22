<?php

namespace App\Models;

use App\Models\Traits\RecordHelpers;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property-read string $singleItemCacheKey
 */
class ProductSeller extends Model
{
    use HasFactory;
    use SoftDeletes;
    use RecordHelpers;
    // use Traits\OnlyTenantScopeTrait; // Only Tenant
    // use Traits\OnlyGlobalScopeTrait; // Only Global (not tenant)

    // public $table = '';

    protected $fillable = [
        'name',
        'slug',
        'icon_url',
        'base64_icon',
        'default_affiliate_page',
        'show_default_affiliate_page',
        'page_direct_links',
        'page_content',
    ];

    protected $casts = [
        'show_default_affiliate_page' => 'boolean',
        'page_direct_links' => AsCollection::class,
    ];

    protected $appends = [
        //
    ];
}
