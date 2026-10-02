<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;

/**
 * App\Models\Base\ArticleCategory
 *
 * @property int $id
 * @property string $title
 * @property int $position
 * @property int $display
 * @property int $hit
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Article[] $articles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory whereHit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\ArticleCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleCategory extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $fillable = [
        'title',
        'position',
        'display',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class,'article_category_id');
    }
}
