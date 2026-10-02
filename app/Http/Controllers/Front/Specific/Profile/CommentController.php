<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Controllers\Front\Base\ProfileController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Comment;

class CommentController extends ProfileController
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Comments
    # Handles comment operations in front user profile
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function index()
    {
        $user = \Auth::user();
        $data = [
            'breadcrumbs' => [
                'active' => 'نظرات من'
            ],
            'user' => \Auth::user(),
            'activeMenu' => 'comments',
            'pageTitle' => 'نظرات',
            'comments' => $user->comments()->where('parent_id', null)->orderBy('created_at', 'desc')->with('commentable')->paginate(PROFILE_PAGINATION_COUNT)
        ];

        return view('front.pages.profile.comments', $data);
    }

    public function edit(Comment $comment)
    {
        if (\Auth::id() != $comment->user_id) {
            abort(404);
        }
        return [
            'view' => \View::make('front.partial.ajax.edit-comment', compact('comment'))->render()
        ];
    }

    public function update(Request $request, Comment $comment)
    {
        if (\Auth::id() != $comment->user_id) {
            abort(404);
        }
        $rules = [
            'comment' => 'required',
        ];
        $request->merge(['status' => 'pending']);
        if (!$comment->parent_id) {
            $fields = ['comment', 'rate', 'status'];
            $rules['rate'] = 'Nullable|numeric|max:5|min:0';
        } else {
            $fields = ['comment', 'status'];
        }
        $this->validate($request, $rules, [], ['comment' => 'نظر']);
        $comment->update($request->only($fields));
        setSession([
            'type' => 'success',
            'message' => 'نظر شما با موفقیت ویرایش گردید',
            'header' => 'ویراش نظر موفق'
        ], 'notification');
        return [
            'url' => back()->getTargetUrl()
        ];
    }

    public function destroy(Comment $comment)
    {
        if (\Auth::id() != $comment->user_id) {
            abort(404);
        }

        if (!$comment->parent_id && $comment->answers()->count()) {
            $array = ['#comment-' . $comment->id];
            $comment->answers->each(function ($answer) use (&$array) {
                array_push($array, '#comment-' . $answer->id);
            });
            $comment->delete();
            return [
                'deletedItem' => $array
            ];
        }
        return [
            'deletedItem' => '#comment-' . $comment->id
        ];
    }
}
