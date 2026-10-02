<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Models\Specific\FirstPageSpecialSell;
use App\Models\Specific\Plan;
use App\Models\Specific\ProductDetail;
use App\Models\Specific\Shop;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FirstPageSpecialSellController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت فروش ویژه', "link" => route('admin.firstPageSpecialSell.index')]
        ];
        $data = [
            'items' => $items,
            'firstPageSpecialSells' => FirstPageSpecialSell::count()
        ];
        return view('admin.specific.specialsell.index', $data);
    }

    public function create()
    {
        $items = [
            ["title" => 'مدیریت فروش ویژه', "link" => route('admin.firstPageSpecialSell.index')],
            ["title" => 'افزودن فروش ویژه', "link" => route('admin.firstPageSpecialSell.create')],
        ];
        $data = [
            'items' => $items,
            'shops' => Shop::visible()->orderBy('title')->get(),
            'plans' => Plan::orderBy('position', 'desc')->get()
        ];
        return view('admin.specific.specialsell.create', $data);
    }

    public function store(Request $request)
    {
        $this->validator($request);
        $productDetail = ProductDetail::findOrFail($request->get('product_detail_id'));

        if ($productDetail->inFirstPage('specialSell')) {
            return back()->with('err', 'این محصول در حال حاضر در صفحه اصلی قرار گرفته است');
        }
        $plan = Plan::findOrFail($request->get('plan_id'));
        $function = 'add' . $plan->func;
        $expiresAt = Carbon::now()->$function($plan->amount);
        $productDetail->specialSell()->create()->firstPageSpecialSell()->create([
            'plan_id' => $plan->id,
            'expires_at' => $expiresAt
        ]);
        return back()->with('msg', __('messages.add_item'));
    }

    public function destroy(Request $request, $firstPageSpecialSell)
    {
        $firstPageSpecialSells = FirstPageSpecialSell::find($request->input('ids'));
        foreach ($firstPageSpecialSells as $index => $firstPageSpecialSell) {
            $firstPageSpecialSell->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = FirstPageSpecialSell::query();
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
            ->addColumn('title', function ($model) {
                return $model->specialSell->productDetail->product->title;
            }, 1)
            ->addColumn('image', function ($model) {
                return '<img src="' . $model->specialSell->productDetail->product->takeImage('main', '60/60') . '" width="60"/>';
            }, 1)
            ->editColumn('plan_id', function ($model) {
                return $model->plan->title;
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('expires_at', '{{ShowDate($expires_at)}} <br> {{ShowTime($expires_at)}}')
            ->escapeColumns([])
            ->make(true);
    }

    protected function validator(Request $request)
    {
        $this->validate($request, [
            'plan_id' => 'required|exists:plans,id',
            'shop_id' => 'required|exists:shops,id',
            'product_id' => 'required|exists:products,id',
            'product_detail_id' => 'required|exists:product_details,id'
        ], [], [
            'plan_id' => 'پلن',
            'shop_id' => 'فروشگاه',
            'product_id' => 'محصول',
            'product_detail_id' => 'زیر محصول'
        ]);
    }
}
