<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Color;
use App\Http\Requests\Admin\Base\ColorRequest;

use DataTables;

class ColorController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_color'),"link" => route('admin.color.index')]
        ];
        $data['objects'] = Color::all();
        return view('admin.pages.color.index', compact('items','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_color'),"link" => route('admin.color.index')],
            ["title" => __('content.create_color'),"link" => route('admin.color.create')]
        ];
        return view('admin.pages.color.create',compact('items'));
    }


    public function store(ColorRequest $request)
    {
        Color::create($request->all());
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit(Color $color)
    {
        $items = [
            ["title" => __('content.management_color'),"link" => route('admin.color.index')],
            ["title" => $color->name,"link" => "#"]
        ];
        return view('admin.pages.color.edit', compact('items','color'));
    }

    public function update(ColorRequest $request,Color $color)
    {
        $color->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$color)
    {
        if($color == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                $color = Color::find($id);
                if(!$color->products->count()) {
                    $color->delete();
                }
            }
        } else {
            $color = Color::find($color);
            if(!$color->products->count()) {
                $color->delete();
            }
        }
    }

    public function DataTable(Request $request)
    {
        $model = Color::select(['id','title','code','created_at', 'updated_at','display', 'position']);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                            data-model="'.get_class($model).'"
                            data-database="mysql">
                        <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">'.$model->position.'</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                if($model->productDetails()->count() || $model->code=='#00NANNAN'){
                    return "";
                } else {
                    return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
                }
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->editColumn('code', function ($model) {
                return '<div style="background-color: '.$model->code.';padding: 10px;width: 35px;height: 35px;margin: 0 auto;"> </div>';
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
                return '<a href="'.route('admin.color.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
