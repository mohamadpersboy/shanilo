<?php

namespace App\Http\Controllers\Admin\Base;

use App\Models\Base\SiteContentImage;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteContentImageController extends Controller
{
    const THUMBNAIL_SIZE=['300/200','60/60'];
    public function index()
    {
        $items = [
            ["title" => __('content.site_content_image_management'),"link" => route('admin.siteContentImage.index')]
        ];

        $data=[
            'items'=>$items,
            'siteContentImages'=>SiteContentImage::visible()->count()
        ];
        return view('admin.pages.sitecontentimage.index',$data);
    }

    public function create()
    {
        $items = [
            ["title" => __('content.site_content_image_management'),"link" => route('admin.siteContentImage.index')],
            ["title" => __('content.create_site_content_image'),"link" => route('admin.siteContentImage.create')]
        ];
        $data=[
            'items'=>$items,
        ];
        return view('admin.pages.sitecontentimage.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|max:255',
            'name'=>'required|max:255|unique:site_content_images,title',
            'pic'=>'required|mimes:jpeg,jpg,png,gif'
        ]);
        $siteContentImage=SiteContentImage::create($request->all());
        $siteContentImage->createImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZE);
        return back()->with('msg',__('messages.add_item'));
    }
    
    public function edit(SiteContentImage $siteContentImage)
    {
        $items = [
            ["title" => __('content.site_content_image_management'),"link" => route('admin.siteContentImage.index')],
            ["title" => __('content.edit_site_content_image'),"link" => route('admin.siteContentImage.edit',$siteContentImage)]
        ];
        $data=[
            'items'=>$items,
            'edit'=>true,
            'siteContentImage'=>$siteContentImage
        ];
        return view('admin.pages.sitecontentimage.edit',$data);
    }

    public function update(Request $request,SiteContentImage $siteContentImage)
    {
        $this->validate($request,[
            'title'=>'required|max:255',
            'name'=>'required|max:255|unique:site_content_images,title,'.$siteContentImage->id
        ]);
        $siteContentImage->update($request->all());
        if($request->file('pic')){
            $siteContentImage->updateImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZE);
        }
        return back()->with('msg',__('messages.edit_item'));
    }

    public function destroy(Request $request,$siteContentImage)
    {
        $siteContentImages=SiteContentImage::find($request->get('ids'));
        foreach ($siteContentImages as $siteContentImage){
            $siteContentImage->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = SiteContentImage::select(['id','title','created_at', 'updated_at', 'display', 'position']);
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
                return '<a href="'.route('admin.siteContentImage.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->addColumn('image', function ($model) {
                return '<img src="'.$model->takeImage('main','60/60').'"/>';
            }, 1)
            ->escapeColumns([])
            ->make(true);
    }
}
