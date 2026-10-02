<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Models\Specific\TechnicalSpecification;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TechnicalSpecificationController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت مشخصات فنی', "link" => route('admin.technicalSpecification.index')]
        ];
        $data = [
            'items' => $items,
            'technicalSpecifications' => TechnicalSpecification::count()
        ];
        return view('admin.specific.technicalspecification.index', $data);
    }

    public function create()
    {
        $items = [
            ["title" => 'مدیریت مشخصات فنی', "link" => route('admin.technicalSpecification.index')],
            ["title" => 'افزودن مشخصه فنی', "link" => route('admin.technicalSpecification.create')],
        ];
        $data = [
            'items' => $items
        ];
        return view('admin.specific.technicalspecification.create', $data);
    }

    public function store(Request $request)
    {
        $this->validator($request);
        TechnicalSpecification::create($request->all());
        return back()->with('msg', __('messages.add_item'));
    }

    public function edit(TechnicalSpecification $technicalSpecification)
    {
        $items = [
            ["title" => 'مدیریت مشخصات فنی', "link" => route('admin.technicalSpecification.index')],
            ["title" => 'ویرایش مشخصه فنی', "link" => route('admin.technicalSpecification.edit', $technicalSpecification)],
        ];
        $data = [
            'items' => $items,
            'technicalSpecification' => $technicalSpecification,
            'edit' => true,
        ];
        return view('admin.specific.technicalspecification.edit', $data);
    }

    public function update(Request $request, TechnicalSpecification $technicalSpecification)
    {
        $this->validator($request,$technicalSpecification);
        $technicalSpecification->update($request->all());
        return back()->with('msg', __('messages.edit_item'));
    }

    public function destroy(Request $request, $technicalSpecification)
    {
        $technicalSpecifications = TechnicalSpecification::find($request->input('ids'));
        foreach ($technicalSpecifications as $index => $technicalSpecification) {
            $technicalSpecification->delete();
        }
    }

    /**
     * @param Request $request
     */
    protected function validator(Request $request,$technicalSpecification=null)
    {
        $rules=[
            'title'=>'required|max:60|unique:technical_specifications,title'
        ];
        if($technicalSpecification){
            $rules['title']='required|max:60|unique:technical_specifications,title,'.$technicalSpecification->id;
        }

        $this->validate($request, $rules);
    }

    public function DataTable(Request $request)
    {
        $model = TechnicalSpecification::query();
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                                data-model="' . get_class($model) . '"
                                data-database="mysql">
                            <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">' . $model->position . '</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                               data-id="' . $model->id . '"
                               data-model="' . get_class($model) . '"
                               data-database="mysql"
                               data-link="' . route('admin.switch.update', $model->id) . '"
                               value="1" ' . ($model->display == 1 ? 'checked="checked"' : '') . ' >
                            </label>';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="' . route('admin.technicalSpecification.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
