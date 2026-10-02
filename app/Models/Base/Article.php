<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;

/**
 * App\Models\Base\Article
 *
 * @property int $id
 * @property int|null $article_category_id
 * @property string $title
 * @property string|null $source
 * @property string|null $link
 * @property string|null $summery
 * @property string|null $description
 * @property int $position
 * @property int $display
 * @property int $hit
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Base\ArticleCategory|null $article_category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Attachment[] $attachments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Article[] $relatedArticles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereArticleCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereHit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereSummery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait;

    protected $fillable = [
        'title',
        'source',
        'link',
        'summery',
        'description',
        'article',
        'position',
        'display',
        'hit',
        'article_category_id',
    ];

    public function article_category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function relatedArticles()
    {
        return $this->belongsToMany(self::class,'article_article','article_id','related_article_id');
    }
}
