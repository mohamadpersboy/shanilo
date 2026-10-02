<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Base\Announcement
 *
 * @property int $id
 * @property int $user_id
 * @property string $description
 * @property int $seen
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Base\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Announcement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Announcement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Announcement whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Announcement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Announcement whereUserId($value)
 * @mixin \Eloquent
 */
class Announcement extends Model
{
    protected $fillable=[
        'user_id',
        'description',
        'seen'
    ];
    /******************************/
    //Relations
    /******************************/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /******************************/
    //Helpers
    /******************************/
    public function setAsSeen()
    {
        $this->update(['seen'=>1]);
    }
}
