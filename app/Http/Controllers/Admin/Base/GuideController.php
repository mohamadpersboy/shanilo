<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Guide;
use App\Http\Requests\Admin\Base\GuideRequest;

use DataTables;

class GuideController extends Controller
{
    const THUMBNAIL_SIZES=['550/400','60/0'];
    public function index()
    {
        $items = [
            ["title" => __('content.management_guide'),"link" => route('admin.guide.index')]
        ];
        $data['objects'] = Guide::all();
        return view('admin.pages.guide.index', compact('items','data'));
    }

    public function store(GuideRequest $request)
    {
        /*$this->validate($request, [
            'pic' => 'required',
        ],[],[
            'pic' => 'عکس',
        ]);*/
        $create = Guide::create($request->all());
        if($request->file('pic')){
            $create->createImage($request->file('pic'), 'main',$request->get('cropper'),self::THUMBNAIL_SIZES);
        }
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($guide)
    {
        $guide = Guide::find($guide);
        $items = [
            ["title" => __('content.management_guide'),"link" => route('admin.guide.index')],
            ["title" => $guide->name,"link" => "#"]
        ];
        return view('admin.pages.guide.edit', compact('items','guide'));
    }

    public function update(GuideRequest $request, $guide)
    {
        $update = Guide::find($guide);
        if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main',$request->get('cropper'),self::THUMBNAIL_SIZES);
        }
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$guide)
    {
        if($guide == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                Guide::find($id)->delete();
            }
        } else {
            Guide::find($guide)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Guide::select(['id','title','display','created_at', 'updated_at', 'position']);
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
            ->addColumn('image', function ($model) {
                return '<img src="'.$model->takeImage('main','60/0').'"/>';
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
                return '<a href="'.route('admin.guide.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
