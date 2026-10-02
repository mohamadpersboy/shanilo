<?php

namespace App\Http\Controllers\Front\Specific;

use App\Http\Controllers\Front\Traits\Specific\HasForbiddenMessageAndView;
use App\Models\Base\Comment;
use App\Models\Specific\Product;
use App\Models\Specific\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    use HasForbiddenMessageAndView;

    public function index($object, $id)
    {
        $object = $this->getObject($object, $id);
        $data = [
            'object' => $object,
            'comments' => $object->comments()->parents()->with('answers')->latest()->get(),
            'canAnswer' => true
        ];
        return [
            'view' => \View::make('front.partial.ajax.comments', $data)->render()
        ];
    }

    public function store(Request $request, $object, $id)
    {
        $this->validate($request, [
            'comment' => 'required',
            'rate' => 'required|min:1|max:5'
        ]);
        $object = $this->getObject($object, $id);
        if (!canComment($object)) {
            return $this->forbiddenMessage();
        }
        if (auth()->user()->hasCommentedTo($object)) {
            return response()->json(['failed' => ['errors' => ['forbidden' => ['شما قبلا نظر خود را راجع به این آیتم ثبت کرده اید.']]]], 422);
        }
        $request->merge([
            'user_id' => auth()->id(),
            'status' => 'confirmed'
        ]);
        $object->comments()->create($request->all());
        $message = [
            'header' => 'ثبت نظر',
            'message' => 'نظر شما با موفقیت ثبت گردید',
            'type' => 'success'
        ];
        if ($object->comments()->count() == 1) {
            setSession($message);
            return [
                'url' => back()->getTargetUrl()
            ];
        }

        return $message;
    }

    public function reply(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);
        $object = $comment->commentable;
        $request->merge([
            'user_id' => auth()->id(),
            'status' => 'confirmed',
            'parent_id' => $comment->id,
            'rate' => 0
        ]);
        $object->comments()->create($request->all());
        return [
            'header' => 'ثبت پاسخ',
            'message' => 'پاسخ شما با موفقیت ثبت گردید.',
            'type' => 'success'
        ];
    }

    public function destroy(Comment $comment)
    {
        if (!$comment->isCommentedByAuth()) {
            return $this->forbiddenMessage();
        }
        $comment->delete();
        if($comment->commentable->comments()->count()==0){
            return [
                'url'=>back()->getTargetUrl()
            ];
        }
        return [
            'deletedItem' => "#comment-{$comment->id}"
        ];
    }

    protected function getObject($object, $id)
    {
        if ($object == 'shop') {
            return Shop::findOrFail($id);
        } elseif ($object == 'product') {
            return Product::findOrFail($id);
        } else {
            abort(404);
        }
    }
}
