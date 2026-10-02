<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Member;
use App\Models\Base\MemberCategory;
use App\Http\Requests\Admin\Base\MemberRequest;

use DataTables;

class MemberController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_member'),"link" => route('admin.member.index')]
        ];
        $data['objects'] = Member::all();
        return view('admin.pages.member.index', compact('items','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_member'),"link" => route('admin.member.index')],
            ["title" => __('content.create_member'),"link" => route('admin.member.create')]
        ];
        $data['categories'] = MemberCategory::visible()->get();
        return view('admin.pages.member.create',compact('items','data'));
    }


    public function store(MemberRequest $request)
    {
        $this->validate($request, [
            'pic' => 'required',
        ]);
        $create = Member::create($request->all());
        $create->createImage($request->file('pic'), 'main',$request->get('cropper'),['60/60']);
        return redirect()->route('admin.member.edit',$create->id)->with('msg', __('messages.add_item'));
    }

    public function edit($member)
    {
        $member = Member::find($member);
        $items = [
            ["title" => __('content.management_member'),"link" => route('admin.member.index')],
            ["title" => $member->name,"link" => "#"]
        ];
        $data['categories'] = MemberCategory::visible()->get();
        return view('admin.pages.member.edit', compact('items','member','data'));
    }

    public function update(MemberRequest $request, $member)
    {
        $update = Member::find($member);
        if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main',$request->get('cropper'),['60/60']);
        }
        Member::find($member)->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$member)
    {
        if($member == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                Member::find($id)->delete();
            }
        } else {
            Member::find($member)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Member::select(['id','name','created_at', 'updated_at', 'display', 'position']);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                            data-model="'.get_class($model).'"
                            data-database="mysql">
                        <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">'.$model->position.'</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="'.$model->id.'"
                           data-model="'.get_class($model).'"
                           data-database="mysql"
                           data-link="'.route('admin.switch.update',$model->id).'"
                           value="1" '.($model->display == 1 ? 'checked="checked"':'').' >
                        </label>';}, 1)
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.member.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->addColumn('image', function ($model) {
                return '<img src="'.$model->takeImage('main','60/60').'"/>';
            }, 1)
            ->escapeColumns([])
            ->make(true);
    }
}
