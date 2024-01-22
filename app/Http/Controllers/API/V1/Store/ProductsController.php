<?php

namespace App\Http\Controllers\API\V1\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Product;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = QueryBuilder::for(Product::class)
            ->allowedFields([
                'id',
                'name',
                'small_description',
                'long_description',
                'images',
                'featured',
                'show_in_store',
                'created_at',
                'updated_at',
                'deleted_at',
                'products.prices.id',
            ])
            ->allowedFilters([
                'name',
                'small_description',
                AllowedFilter::exact('featured'),
                AllowedFilter::exact('show_in_store'),
                AllowedFilter::scope('created_after'),
                AllowedFilter::scope('created_before'),
                // AllowedFilter::trashed(), // https://spatie.be/docs/laravel-query-builder/v4/features/filtering#content-trashed-filters
                AllowedFilter::scope('deleted')->default(false),
                AllowedFilter::callback('onlyWhereHas', function (Builder $query, $value) {
                    $query->with($value);

                    if (is_string($value)) {
                        $query = $query->whereHas('prices');

                        return;
                    }

                    if (is_array($value)) {
                        foreach (array_filter($value, fn ($v) => $v && is_string($v)) as $relation) {
                            $query = $query->whereHas($relation);
                        }

                        return;
                    }
                }),
                AllowedFilter::callback('customSearch', function (Builder $query, $value) {
                    if (!is_string($value) || strlen(trim($value)) < 3) {
                        $query = $query->whereId(0);

                        return;
                    }

                    $value = str($value)->trim()->prepend('%')->append('%')->toString();

                    $query
                        ->where('name', 'like', $value)
                        ->orWhere('small_description', 'like', $value)
                        ->orWhere('long_description', 'like', $value);
                }),
            ])
            ->allowedSorts([
                'id',
                'name',
                'featured',
                'created_at',
                'updated_at',
            ])
            ->allowedIncludes([
                'prices',
                'cheaper',
                'moreExpensive',

                // #content-nested-relationships
                // https://spatie.be/docs/laravel-query-builder/v4/features/including-relationships#content-nested-relationships
                // 'product.prices',
                // 'product.cheaper',
                // 'product.moreExpensive',

                'prices.seller',
                'cheaper.seller',
                'moreExpensive.seller',
            ])
            // ->defaultSort('-id')
            // ->with([
            //     'prices',
            // ])
            // ->whereHas('prices')
            ->jsonPaginate();

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function search(Request $request, ?string $search = null)
    {
        $search = trim($search ?: $request->input('search')) ?: $request->input('q');
        $search = trim($search ?: $request->input('filter.customSearch'));

        $request->merge([
            'filter' => ['customSearch' => $search],
        ]);

        return $this->index($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
