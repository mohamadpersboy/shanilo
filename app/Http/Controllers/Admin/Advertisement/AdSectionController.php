<?php

namespace App\Http\Controllers\Admin\Advertisement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Advertisement\AdSection;
use App\Http\Requests\Admin\Advertisement\AdSectionRequest;

use DataTables;
use Activity;

class AdSectionController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_adsection'),"link" => route('admin.adsection.index')]
        ];

        $header['list'] = ["title" => __('content.management_adsection'),"description" => __('content.list_of_adsection')];
        $header['create'] = ["title" => __('content.management_adsection'),"description" => __('content.create_adsection')];

        $data['adsections'] = AdSection::all();
        return view('admin.pages.adsection.index', compact('items','header','data'));
    }

    public function store(AdSectionRequest $request)
    {
        $this->validate($request, [
            'pic' => 'required',
        ],[],[
            'pic' => 'عکس',
        ]);
        $create = AdSection::create($request->all());
        $create->createImage($request->file('pic'), 'main',null,['100/0']);
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($adsection)
    {
        $adsection = AdSection::findorFail($adsection);

        $items = [
            ["title" => __('content.management_adsection'),"link" => route('admin.adsection.index')],
            ["title" => $adsection->title,"link" => "#"]
        ];

        $header['edit'] = ["title" => __('content.management_adsection'),"description" => __('content.edit_adsection')];

        $data['logactivity'] = Activity::where([['subject_type',get_class($adsection)],['subject_id',$adsection->id]])->oldest()->get();

        return view('admin.pages.adsection.edit', compact('items','header','data','adsection'));
    }

    public function update(AdSectionRequest $request, $adsection)
    {
        $update = AdSection::find($adsection);
        if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main',null,['100/0']);
        }
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$adsection)
    {
        if($adsection == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                AdSection::find($id)->delete();
            }
        } else {
            AdSection::find($adsection)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = AdSection::query();
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
                return '<img src="'.$model->takeImage('main','100/0').'"/>';
            }, 1)
            ->editColumn('title', function ($model) {
                return $model->title."<br><i style='direction:ltr;display: inline-block;'>".$model->width." x ".$model->height."</i>";
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
                return '<a href="'.route('admin.adsection.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
