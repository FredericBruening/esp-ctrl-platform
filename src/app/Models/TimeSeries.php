<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TimeSeries
 *
 * @method static \Database\Factories\TimeSeriesFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSeries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSeries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSeries query()
 * @mixin \Eloquent
 */
class TimeSeries extends Model
{
    use HasFactory;

    protected $guarded = [];
}
