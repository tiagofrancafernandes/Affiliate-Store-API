<?php

namespace App\Models;

use App\Models\Traits\RecordHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property-read string $singleItemCacheKey
 */
class Media extends Model
{
    use HasFactory;
    use SoftDeletes;
    use RecordHelpers;
    // use Traits\OnlyTenantScopeTrait; // Only Tenant
    // use Traits\OnlyGlobalScopeTrait; // Only Global (not tenant)

    // public $table = '';

    protected $fillable = [
        'model_id',
        'model_type',
        'filename',
    ];

    protected $casts = [
        //
    ];

    protected $appends = [
        //
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->morphTo();
    }
}
