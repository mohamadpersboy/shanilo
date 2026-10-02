<?php

namespace App\Http\Controllers\Admin\Specific;

use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Specific\Plan;

class PlanController extends Controller
{
    const FUNCS = [
        'Minutes' => 'دقیقه',
        'Hours' => 'ساعت',
        'Days' => 'روز',
        'Weeks' => 'هفته',
        'Months' => 'ماه'
    ];

    public function index()
    {
        $items = [
            ["title" => 'مدیریت پلن ها', "link" => route('admin.plan.index')]
        ];
        $data = [
            'items' => $items,
            'plans' => Plan::count()
        ];
        return view('admin.specific.plan.index', $data);
    }

    public function create()
    {
        $items = [
            ["title" => 'مدیرت پلن محصولات', "link" => route('admin.plan.index')],
            ["title" => 'افزودن پلن محصول', "link" => route('admin.plan.create')],
        ];
        $data = [
            'items' => $items,
            'funcs' => self::FUNCS,
        ];
        return view('admin.specific.plan.create', $data);
    }

    public function store(Request $request)
    {
        $this->validator($request);
        Plan::create($request->all());
        return back()->with('msg', __('messages.add_item'));
    }

    public function edit(Plan $plan)
    {
        $items = [
            ["title" => 'مدیریت پلن محصولات', "link" => route('admin.plan.index')],
            ["title" => 'ویرایش پلن', "link" => route('admin.plan.edit', $plan)],
        ];
        $data = [
            'items' => $items,
            'plan' => $plan,
            'edit' => true,
            'funcs'=>self::FUNCS
        ];
        return view('admin.specific.plan.edit', $data);
    }

    public function update(Request $request, Plan $plan)
    {
        $this->validator($request);
        $plan->update($request->all());
        return back()->with('msg',__('messages.edit_item'));
    }
    protected function validator(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:30',
            'func' => 'required|in:' . implode(',', array_keys(self::FUNCS)),
            'price' => 'required|numeric|min:100',
            'amount' => 'required|numeric'
        ], [], [
            'func' => 'نوع زمان',
            'amount' => 'مقدار زمان'
        ]);
    }

    public function destroy(Request $request, $plan)
    {
        $plans = Plan::find($request->input('ids'));
        foreach ($plans as $index => $plan) {
            $plan->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Plan::query();
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                                data-model="' . get_class($model) . '"
                                data-database="mysql">
                            <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">' . $model->position . '</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                $firstPageSpecialSells = $model->firstPageSpecialSells()->remaining()->count();
                $firstPageSpecialSuggestions = $model->firstPageSpecialSuggestions()->remaining()->count();
                if ($firstPageSpecialSuggestions || $firstPageSpecialSells) {
                    return '';
                }
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->editColumn('func', function ($model) {
                return self::FUNCS[$model->func];
            }, 1)
            ->editColumn('price', function ($model) {
                return showPrice($model->price, null);
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
                return '<a href="' . route('admin.plan.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
