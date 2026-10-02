<?php

namespace App\Http\Controllers\Admin\Base;

use App\Models\Base\Country;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت کشورها', "link" => route('admin.country.index')]
        ];
        $data = [
            'items' => $items,
            'countries' => Country::count()
        ];
        return view('admin.pages.country.index', $data);
    }

    public function create()
    {
        $items = [
            ["title" => 'مدیریت کشورها', "link" => route('admin.country.index')],
            ["title" => 'ساخت کشور', "link" => route('admin.country.create')],
        ];
        $data = [
            'items' => $items
        ];
        return view('admin.pages.country.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60'
        ]);
        Country::create($request->all());
        return back()->with('msg', __('messages.add_item'));
    }

    public function edit(Country $country)
    {
        $items = [
            ["title" => 'مدیریت کشورها', "link" => route('admin.country.index')],
            ["title" => 'ویرایش کشور', "link" => route('admin.country.edit', $country)],
        ];
        $data = [
            'items' => $items,
            'country' => $country,
            'edit' => true,
        ];
        return view('admin.pages.country.edit', $data);
    }

    public function update(Request $request, Country $country)
    {
        $this->validate($request, [
            'name' => 'required|max:60'
        ]);
        $country->update($request->all());
        return back()->with('msg', __('messages.edit_item'));
    }

    public function destroy(Request $request, $country)
    {
        $countries = Country::find($request->input('ids'));
        foreach ($countries as $index => $country) {
            $country->delete();
        }
    }

    public function DataTable(Request $request)
        {
            $model = Country::query();
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
                /*->addColumn('image', function ($model) {
                    return '<img src="' . $model->takeImage('main', '60/60') . '"/>';
                }, 1)*/
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
                    return '<a href="' . route('admin.country.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
                })
                ->escapeColumns([])
                ->make(true);
        }
}
