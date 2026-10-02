<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Requests\Admin\Base\AboutRequest;
use App\Models\Base\AboutUs;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیرت محتوای درباره ما',"link" => route('admin.aboutUs.index')]
        ];
        $data=[
            'items'=>$items,
            'aboutUses'=>AboutUs::count()
        ];
        return view('admin.pages.aboutus.index', $data);
    }

    public function create()
    {

        $data=[
            'items' => [
                ["title" => __('content.about_us_management'),"link" => route('admin.news.index')],
                ["title" => __('content.create_about_us'),"link" => route('admin.news.create')]
            ]
        ];
        return view('admin.pages.aboutus.create',$data);
    }

    public function store(AboutRequest $request)
    {
        $aboutUs = AboutUs::create($request->all());
        if($request->file('pic')){
        $aboutUs->createImage($request->file('pic'), 'main',$request->get('cropper'), ['400/500','400/250','300/200','60/60']);
        }
        return back()->with('msg',__('messages.add_item'));
    }
    
    public function edit($id)
    {
        $aboutUs=AboutUs::findOrFail($id);
        $data=[
            'items'=> [
                ["title" => __('content.aboutus_management'),"link" => route('admin.aboutUs.index')],
                ["title" => $aboutUs->title,"link" => "#"]
            ],
            'aboutUs'=>$aboutUs,
            'edit'=>true
        ];
        return view('admin.pages.aboutus.edit', $data);
    }

    public function update(AboutRequest $request,$id)
    {
        $aboutUs=AboutUs::findOrFail($id);
        $aboutUs->update($request->all());
        if($request->file('pic')){
            $aboutUs->updateImage($request->file('pic'), 'main',$request->get('cropper'), ['400/500','400/250','300/200','60/60']);
        }
        return back()->with('msg',__('messages.edit_item'));
    }

    public function destroy(Request $request,$aboutUs)
    {
        $aboutUses=AboutUs::find($request->input('ids'));
        foreach ($aboutUses as $aboutUs){
            $aboutUs->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model =AboutUs::query();
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
                return '<img src="'.$model->takeImage('main','60/60').'"/>';
            }, 1)
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="'.$model->id.'"
                           data-model="'.get_class($model).'"
                           data-database="mysql"
                           data-link="'.route('admin.switch.update',$model->id).'"
                           value="1" '.($model->display == 1 ? 'checked="checked"':'').' >
                        </label>';}, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.aboutUs.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
    
}
