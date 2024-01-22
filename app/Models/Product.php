<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\RecordHelpers;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

#[\AllowDynamicProperties]
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use RecordHelpers;

    // public $table = '';

    protected $fillable = [
        'name',
        'small_description',
        'long_description',
        'images',
        'featured',
        'show_in_store',
        'review_rating',
        'show_review_rating',
    ];

    protected $casts = [
        'images' => AsCollection::class,
        'featured' => 'boolean',
        'show_in_store' => 'boolean',
        'review_rating' => 'float',
        'show_review_rating' => 'boolean',
    ];

    protected $appends = [
        //
    ];

    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }

    /**
     * Get all of the priceList for the Product
     *
     * @return HasMany
     */
    public function priceList(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    /**
     * Get all of the publicPriceList for the Product
     *
     * @return HasMany
     */
    public function publicPriceList(): HasMany
    {
        return $this->priceList()
            ->orderBy('main_price')
            ->orderBy('promo_price')
            ->orderBy('current_price')
            ->where('show_in_store', true);
    }

    /**
     * @return HasMany
     */
    public function prices(): HasMany
    {
        return $this->publicPriceList();
    }

    /**
     * Get the cheaper product
     */
    public function cheaper(): HasOne
    {
        return $this->hasOne(ProductPrice::class)
            ->where('show_in_store', true)
            ->ofMany('current_price', 'max'); //!! WIP
    }

    /**
     * Get more expensive product
     */
    public function moreExpensive(): HasOne
    {
        return $this->hasOne(ProductPrice::class)
            ->where('show_in_store', true)
            ->ofMany('current_price', 'min'); //!! WIP
    }

    public function endOfPrices(string $byColumn = 'original_price'): array
    {
        $prices = collect($this->publicPriceList?->sortBy($byColumn)?->pluck($byColumn));

        return array_unique(
            array_filter(
                [
                    $prices->first(),
                    $prices->last(),
                ]
            )
        );
    }

    public function getEndOfPricesAttribute()
    {
        return $this->endOfPrices();
    }

    public function scopeCreatedAfter(Builder $query, \DateTimeInterface|string $date): Builder
    {
        return $query->where('created_at', '=>', Carbon::parse($date));
    }

    public function scopeCreatedBefore(Builder $query, \DateTimeInterface|string $date): Builder
    {
        return $query->where('created_at', '<=', Carbon::parse($date));
    }

    public function scopeDeleted(Builder $query, ?bool $deleted = false): Builder
    {
        if ($deleted === null) {
            return $query;
        }

        if (!$deleted) {
            return $query->withoutTrashed();
        }

        return $query->withTrashed();
    }
}
