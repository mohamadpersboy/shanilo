<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\controllers\Controller;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function deleteFile() {
        $model = request()->get('model');
        $id = request()->get('id');
        $attachment_slug = request()->get('attachment_slug');
        $model::with('attachments')->find($id)->attachmentSlug($attachment_slug)->delete();
    }
}
