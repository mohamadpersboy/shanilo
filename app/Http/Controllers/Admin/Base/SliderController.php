<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Slider;

use DataTables;

class SliderController extends Controller
{
    const THUMBNAIL_SIZE=['1170/450','60/60'];

    public function index()
    {
        $items = [
            ["title" => __('content.management_slider'),"link" => route('admin.slider.index')]
        ];
        $data['objects'] = Slider::all();
        return view('admin.pages.slider.index', compact('items','data'));
    }

    public function store(Request $request)
    {
        $this->validator($request);
        $create = Slider::create($request->all());
        $create->createImage($request->file('pic'), 'main',$request->get('cropper'),self::THUMBNAIL_SIZE);
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($slider)
    {
        $slider = Slider::find($slider);
        $items = [
            ["title" => __('content.management_slider'),"link" => route('admin.slider.index')],
            ["title" => $slider->name,"link" => "#"]
        ];
        return view('admin.pages.slider.edit', compact('items','slider'));
    }

    public function update(Request $request, $slider)
    {
        $this->validator($request);
        $update = Slider::find($slider);
        if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main',$request->get('cropper'),self::THUMBNAIL_SIZE);
        }
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$slider)
    {
        $sliders=Slider::find($request->get('ids'));
        foreach ($sliders as $slider){
            $slider->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Slider::select(['id','title','link','created_at', 'updated_at', 'display', 'position']);
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
                return '<a href="'.$model->link.'" target="_blank"><img src="'.$model->takeImage("main",'60/60').'"/></a>';
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
                return '<a href="'.route('admin.slider.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected function validator(Request $request)
    {
        $rules=[
            'title'=>'required',
            'subtitle'=>'required',
            'link'=>'required',
            'pic'=>'required|mimes:jpg,jpeg,png'
        ];
        if($request->method()=='PATCH'){
            $rules['pic']='required|mimes:jpg,jpeg,png';
        }
        $attributes=[
            'subtitle'=>'زیر عنوان'
        ];
        $this->validate($request,$rules,[],$attributes);
    }
}
