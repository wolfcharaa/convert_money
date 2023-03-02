<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string main_forex
 * @property array  forex_cost_array
 * @property int    id
 */
class ForexCost extends Model
{
    protected $fillable = [
        'main_forex',
        'forex_cost_array',
        'id',
    ];
}
