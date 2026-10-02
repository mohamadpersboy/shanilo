<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Base\Calendar
 *
 * @property int $id
 * @property string $date
 * @property int $morning
 * @property int $noon
 * @property int $afternoon
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Calendar whereAfternoon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Calendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Calendar whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Calendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Calendar whereMorning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Calendar whereNoon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Calendar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Calendar extends Model
{
    protected $fillable = [
        'date',
        'morning',
        'noon',
        'afternoon',
    ];
}
