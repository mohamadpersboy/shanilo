<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;

/**
 * App\Models\Base\AdminBank
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Attachment[] $attachments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AdminBank inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AdminBank sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AdminBank visible()
 * @mixin \Eloquent
 */
class AdminBank extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait;

    protected $fillable = [
        'title',
        'name',
        'account_number',
        'account_card',
        'account_shaba',
        'admin_id',
        'position',
        'display',
    ];

   /* public function admin()
    {
        return $this->belongsTo(Admin::class);
    }*/
}
