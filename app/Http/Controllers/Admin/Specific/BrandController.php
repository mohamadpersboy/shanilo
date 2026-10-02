<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Models\Specific\Article;
use App\Models\Specific\Brand;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت برندها', "link" => route('admin.brand.index')]
        ];
        $data = [
            'items' => $items,
            'brands' => Brand::count()
        ];
        return view('admin.specific.brand.index', $data);
    }

    public function create()
    {
        $items = [
            ["title" => 'مدیریت برندها', "link" => route('admin.brand.index')],
            ["title" => 'افزودن برند', "link" => route('admin.brand.create')],
        ];
        $data = [
            'items' => $items
        ];
        return view('admin.specific.brand.create', $data);
    }

    public function store(Request $request)
    {
        $this->validator($request);
        Brand::create($request->all());
        return back()->with('msg', __('messages.add_item'));
    }

    public function edit(Brand $brand)
    {
        $items = [
            ["title" => 'مدیریت برندها', "link" => route('admin.brand.index')],
            ["title" => 'ویرایش برند', "link" => route('admin.brand.edit', $brand)],
        ];
        $data = [
            'items' => $items,
            'brand' => $brand,
            'edit' => true,
        ];
        return view('admin.specific.brand.edit', $data);
    }

    public function update(Request $request, Brand $brand)
    {
        $this->validator($request);
        $brand->update($request->all());
        return back()->with('msg', __('messages.edit_item'));
    }

    public function DataTable(Request $request)
    {
        $model = Brand::query();
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                                data-model="' . get_class($model) . '"
                                data-database="mysql">
                            <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">' . $model->position . '</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                if ($model->products()->count()) {
                    return '';
                }
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
                return '<a href="' . route('admin.brand.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function destroy(Request $request, $brand)
    {
        $brands = Brand::find($request->input('ids'));
        foreach ($brands as $index => $brand) {
            $brand->delete();
        }
    }

    /**
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
    }
}
