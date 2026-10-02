<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Comment;

use DataTables;

class CommentController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_comment'),"link" => "#"],
            ["title" => 'لیست نظرات',"link" => "#"],
        ];
        $data['objects'] = Comment::all();
        return view('admin.pages.comment.index', compact('items','data'));

    }

    public function edit($comment)
    {
        $comment = Comment::find($comment);
        $items = [
            ["title" => __('content.management_comment'),"link" => route('admin.comment.index',$comment->status)],
            ["title" => $comment->title,"link" => "#"]
        ];
        return view('admin.pages.comment.edit', compact('items','comment'));
    }

    public function update(CommentRequest $request, $comment)
    {
        Comment::find($comment)->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$comment)
    {
        $ids=$request->get('ids');
        $comments=Comment::find($ids);
        foreach ($comments as $comment){
            $comment->delete();
        }
    }

    public function DataTable(Request $request)
    {
        Comment::all()->each(function ($comment){
            if($comment->commentable==null){
                $comment->delete();
            }
        });
        $model = Comment::query()->orderBy('updated_at','desc')->orderBy('created_at','desc');
        if($request->input('status')){
            $model->where('status',$request->get('status'));
        }

        $datatables = DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->addColumn('user', function ($model) {
                return "<a target='blank' href='".route('admin.user.edit',$model->user)."'>".getUsersFullName($model->user)."</a>";
            }, 1)
            ->addColumn('title', function ($model) {
                return "<a target='_blank' class='blue' href='".$model->commentable->path()."'>{$model->commentable->title}</a>";
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('status', function ($model) {
                return '<label class="checkradio_style2 switchery-sm">
                          <input name="status" type="checkbox" class="js-switch switch_for_all"
                           data-id="'.$model->id.'"
                           data-model="'.get_class($model).'"
                           data-database="mysql"
                           data-link="'.route('admin.switch.update',$model->id).'"
                           value="1" '.($model->status == 'confirmed' ? 'checked="checked"':'').' >
                        </label>';}, 1)
            ->addColumn('edit', function ($model) {
                $view=\View::make('admin.pages.comment.show',['comment'=>$model])->render();
                return '<a href="#" class="btn_style3 blue"><i class="icon i-letter-mail-1 show_msg"></i></a>
                        <div class="data_msg">'.$view.'</div>';
            })
            ->escapeColumns([]);

        return $datatables->make(true);
    }
}
