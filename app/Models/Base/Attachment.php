<?php

namespace App\Models\Base;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * App\Models\Base\Attachment
 *
 * @property int $id
 * @property int $attachmentable_id
 * @property string $attachmentable_type
 * @property int|null $quality_id
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $slug
 * @property string|null $file_name
 * @property string|null $mime
 * @property string|null $size
 * @property string|null $size_format
 * @property string|null $duration
 * @property int $dl
 * @property int $count
 * @property string|null $group_name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $attachmentable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment slug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereAttachmentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereAttachmentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereDl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereQualityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereSizeFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Attachment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attachment extends Model
{
    protected $fillable = [
        'title',
        'attachmentable_id',
        'attachmentable_type',
        'quality_id',
        'slug',
        'file_name',
        'mime',
        'size',
        'size_format',
        'duration',
        'dl',
        'count',
        'group_name',
    ];

    public function attachmentable()
    {
        return $this->morphTo();
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($attachment) {
            foreach (glob(PATH_TO_UPLOAD . md5($attachment->attachmentable()->get()->first()->getTable()) . '/' . md5($attachment->attachmentable()->get()->first()->id) . "/*" . $attachment->file_name) as $fileName) {
                if (file_exists($fileName)) {
                    unlink($fileName);
                }
            }
            foreach (glob(storage_path('app/') . md5($attachment->attachmentable()->get()->first()->getTable()) . '/' . md5($attachment->attachmentable()->get()->first()->id) . "/*" . $attachment->file_name) as $fileName) {
                if (file_exists($fileName)) {
                    unlink($fileName);
                }
            }

        });

    }



    
    /******************************/
    //Specific
    /******************************/
    public function iconImage()
    {
        $default='_images/default-thumb.png';
        $fileExtension='.'.array_last(explode('.',$this->file_name));
        $extension=Extension::where('extension',$fileExtension)->first();
        return $extension?$extension->takeImage('main'):$default;
    }
}
