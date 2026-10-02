<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Base\Bookmark
 *
 * @property int $id
 * @property int $bookmarkable_id
 * @property string $bookmarkable_type
 * @property int $user_id
 * @property int $bookmark
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $bookmarkable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Bookmark whereBookmark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Bookmark whereBookmarkableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Bookmark whereBookmarkableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Bookmark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Bookmark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Bookmark whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Bookmark whereUserId($value)
 * @mixin \Eloquent
 */
class Bookmark extends Model
{
    protected $fillable = [
        'bookmarkable_id',
        'bookmarkable_type',
        'user_id',
        'bookmark',
    ];

    public function bookmarkable()
    {
        return $this->morphTo();
    }
}
