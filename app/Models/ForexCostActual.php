<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property string created_at
 * @property string updated_at
 * @property int converter_types
 * @property string currency
 * @property float forex
 *
 * @property ConverterType converterType
 */
class ForexCostActual extends Model
{
    protected $fillable = [
        'id',
        'converter_types',
        'currency',
        'forex',
    ];

    protected $casts = [
        'forex' => 'float'
    ];

    public function converterType(): BelongsTo
    {
        return $this->belongsTo('converted_types', 'id');
    }
}
