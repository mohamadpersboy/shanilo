<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\PictureGallery;

use DataTables;

class PictureGalleryController extends Controller
{
    const THUMBNAILS_SIZE=['900/680','290/280','60/60'];

    public function index()
    {
        $items = [
            ["title" => __('content.management_picturegallery'),"link" => route('admin.picturegallery.index')]
        ];
        $data['objects'] = PictureGallery::all();
        return view('admin.pages.picturegallery.index', compact('items','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_picturegallery'),"link" => route('admin.picturegallery.index')],
            ["title" => __('content.create_picturegallery'),"link" => route('admin.picturegallery.create')]
        ];
        return view('admin.pages.picturegallery.create',compact('items'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'pic' => 'required',
        ],[],[
            'pic' => 'عکس',
        ]);
        $create = PictureGallery::create($request->all());
        $create->createImage($request->file('pic'), 'main',null,self::THUMBNAILS_SIZE);
        return back()->with('msg',__('messages.add_item'));
    }

    public function edit($picturegallery)
    {
        $picturegallery = PictureGallery::find($picturegallery);
        $items = [
            ["title" => __('content.management_picturegallery'),"link" => route('admin.picturegallery.index')],
            ["title" => $picturegallery->name,"link" => "#"]
        ];
        return view('admin.pages.picturegallery.edit', compact('items','picturegallery'));
    }

    public function update(Request $request, $picturegallery)
    {
        $update = PictureGallery::find($picturegallery);
        if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main',null,self::THUMBNAILS_SIZE);
        }
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$picturegallery)
    {
        if($picturegallery == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                PictureGallery::find($id)->delete();
            }
        } else {
            PictureGallery::find($picturegallery)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = PictureGallery::select(['id','title','created_at', 'updated_at', 'display', 'position']);
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
                return '<img src="'.$model->takeImage("main",'60/60').'"/>';
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
                return '<a href="'.route('admin.picturegallery.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
