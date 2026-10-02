<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\VideoGallery;
use App\Http\Requests\Admin\Base\VideoGalleryRequest;

use DataTables;

class VideoGalleryController extends Controller
{
    const THUMBNAILS_SIZE=['750/500','290/280','60/60'];

    public function index()
    {
        $items = [
            ["title" => __('content.management_videogallery'),"link" => route('admin.videogallery.index')]
        ];
        $data['objects'] = VideoGallery::all();
        return view('admin.pages.videogallery.index', compact('items','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_videogallery'),"link" => route('admin.videogallery.index')],
            ["title" => __('content.create_videogallery'),"link" => route('admin.videogallery.create')]
        ];
        return view('admin.pages.videogallery.create',compact('items'));
    }

    public function store(VideoGalleryRequest $request)
    {
        $create = VideoGallery::create($request->all());
        $create->createImage($request->file('video_pic'), 'video_picture_preview',$request->get('cropper'),self::THUMBNAILS_SIZE);
        return redirect()->route('admin.videogallery.edit',$create->id)->with('msg', __('messages.add_item'));
    }

    public function edit($videogallery)
    {
        $videogallery = VideoGallery::find($videogallery);
        $items = [
            ["title" => __('content.management_videogallery'),"link" => route('admin.videogallery.index')],
            ["title" => $videogallery->title,"link" => "#"]
        ];
        return view('admin.pages.videogallery.edit', compact('items','videogallery'));
    }

    public function update(VideoGalleryRequest $request, $videogallery)
    {
        $update = VideoGallery::find($videogallery);
        if($request->file('video_pic') != null){
            $update->updateImage($request->file('video_pic'), 'video_picture_preview',$request->get('cropper'),self::THUMBNAILS_SIZE);
        }
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$videogallery)
    {
        if($videogallery == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                VideoGallery::find($id)->delete();
            }
        } else {
            VideoGallery::find($videogallery)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = VideoGallery::select(['id','title','created_at', 'updated_at', 'display', 'position']);
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
                return '<img src="'.$model->takeImage("video_picture_preview",'60/60').'"/>';
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
                return '<a href="'.route('admin.videogallery.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
