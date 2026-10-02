<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\Payment;
use App\Models\Base\Order;
use App\Models\Base\Category;
use App\Models\Base\PayType;
use App\Models\Base\SendType;

use DB;
use Morilog\Jalali\jDateTime;
use Carbon\Carbon;
use DataTables;

class StatisticController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => "گزارش درآمد فروشگاه","link" => "#"]
        ];

        if(isset($_GET['s_date_from']) && isset($_GET['s_date_to']) && $_GET['s_date_to'] != "" && $_GET['s_date_to'] != 0){
            if(str_replace('/','',$_GET['s_date_from']) > str_replace('/','',$_GET['s_date_to'])){
                unset($_GET['s_date_from']);
                unset($_GET['s_date_to']);
                return redirect()->route('admin.statistic.index')->with('alarm','لطفا تاریخ ها را به درستی انتخاب نمایید.');
            }
        }

        if(isset($_GET['s_date_from'])){
            $data['date_from'] = $_GET['s_date_from'];
        } else {
            $now = Carbon::now();
            $data['jalali'] = jDateTime::toJalali($now->year, $now->month, $now->day);
            if($data['jalali'][1] < 10){
                $data['jalali'][1] = "0".$data['jalali'][1];
            }
            $data['date_from'] = $data['jalali'][0]."/".$data['jalali'][1]."/".$data['jalali'][2];
        }

        if(isset($_GET['s_date_to'])){
            $data['date_to'] = $_GET['s_date_to'];
        } else {
            $data['date_to'] = "";
        }

        if(isset($_GET['s_date_from']) || isset($_GET['s_date_to'])){
            $dateFrom = explode('/',$_GET['s_date_from']);
            $Gregorian = jDateTime::toGregorian($dateFrom[0], $dateFrom[1], $dateFrom[2]);
            $dateFrom = Carbon::create($Gregorian[0], $Gregorian[1], $Gregorian[2],0,0,0);

            $dateTo = explode('/',$_GET['s_date_to']);
            if(!empty($dateTo[0])){
                $Gregorian = jDateTime::toGregorian($dateTo[0], $dateTo[1], $dateTo[2]);
                $dateTo = Carbon::createFromDate($Gregorian[0], $Gregorian[1], $Gregorian[2]);
            } else {
                $dateTo = Carbon::now();
            }

            $queryChart = Payment::query()->where([['pay_subject',1],['pay_status',2],['created_at','>=',$dateFrom],['created_at','<=',$dateTo]]);
            $queryChartTwo = Order::query()->whereHas('factor', function ($query) { $query->where('visited', 2);})->where([['created_at','>=',$dateFrom],['created_at','<=',$dateTo]]);
            $queryOnline = Payment::query()->where([['pay_subject',1],['pay_status',2],['created_at','>=',$dateFrom],['created_at','<=',$dateTo]]);
            $queryBalance = Payment::query()->where([['pay_subject',1],['pay_status',2],['created_at','>=',$dateFrom],['created_at','<=',$dateTo]]);
            $queryDoor = Payment::query()->where([['pay_subject',1],['pay_status',2],['created_at','>=',$dateFrom],['created_at','<=',$dateTo]]);
        } else {
            $queryChart = Payment::query()->where([['pay_subject',1],['pay_status',2]]);
            $queryChartTwo = Order::query()->whereHas('factor', function ($query) { $query->where('visited', 2);});
            $queryOnline = Payment::query()->where([['pay_subject',1],['pay_status',2]]);
            $queryBalance = Payment::query()->where([['pay_subject',1],['pay_status',2]]);
            $queryDoor = Payment::query()->where([['pay_subject',1],['pay_status',2]]);
        }

        $queryChart->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(price) as total_price'));
        $queryChart->groupBy('date');
        $data['chartsOne'] = $queryChart->orderBy('date','asc')->get();

        $queryChartTwo->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(quantity) as total_quantity'));
        $queryChartTwo->groupBy('date');
        $data['chartsTwo'] = $queryChartTwo->orderBy('date','asc')->get();
        
        $data['sumPayOnline'] = $queryOnline->where('pay_type',1)->sum('price');
        $data['sumPayBalance'] = $queryBalance->where('pay_type',2)->sum('price');
        $data['sumPayDoor'] = $queryDoor->where('pay_type',3)->sum('price');
        $data['sumPayTotal'] = $data['sumPayOnline'] + $data['sumPayBalance'] + $data['sumPayDoor'];

        return view('admin.pages.statistic.index', compact('items','data'));
    }

    public function sales()
    {
        $items = [
            ["title" => "گزارش فروش کالاها","link" => "#"]
        ];

        $data['categories'] = Category::Visible()->depth(1)->orderBy('position','asc')->take(3)->get();
        $data['send_types'] = SendType::Visible()->orderBy('position')->get();
        $data['pay_types'] = PayType::Visible()->orderBy('position')->get();

        return view('admin.pages.statistic.sales', compact('items','data'));
    }

    public function DataTable(Request $request)
    {

        $model = Order::query();

        $model->whereHas('factor', function ($query) { $query->where('visited', 2);})
        ->select(DB::raw('SUM(price_after_discount*quantity) as total_price'),DB::raw('SUM(quantity) as total_quantity'),'model_id','color_id')
        ->groupBy('model_id','color_id');

        if ($s_model = $request->get('s_model')) {
            $string = anyStrInSearch($s_model);
            $model->whereHas('product', function ($query) use ($string) { $query->where('model','like',$string);} );
        }

        if ($s_brand = $request->get('s_brand')) {
            $model->whereHas('product', function ($query) use ($s_brand) {
                $query->where('brand_id',$s_brand);
            });
        }

        if ($s_category = $request->get('s_category')) {
            $model->whereHas('product', function ($query) use ($s_category) {
                $query->whereHas('categories', function ($query) use ($s_category) {
                    $query->where('id',$s_category);
                });
            });
        }

        if ($s_send = $request->get('s_send')) {
            $model->whereHas('factor', function ($query) use ($s_send) {
                $query->where('send_type_id',$s_send);
            });
        }

        if ($s_pay = $request->get('s_pay')) {
            $model->whereHas('factor', function ($query) use ($s_pay) {
                $query->where('pay_type_id',$s_pay);
            });
        }

        if ($s_date_from = $request->get('s_date_from')) {
            $dateFrom = explode('/',$s_date_from);
            if(!empty($dateFrom[0])){
                $Gregorian = jDateTime::toGregorian($dateFrom[0], $dateFrom[1], $dateFrom[2]);
                $dateFrom = Carbon::create($Gregorian[0], $Gregorian[1], $Gregorian[2],0,0,0);
                $model->whereHas('factor', function ($query) use ($dateFrom) {
                    $query->where('created_at','>=',$dateFrom);
                });
            }
        }

        if ($s_date_to = $request->get('s_date_to')) {
            $dateTo = explode('/',$s_date_to);
            if(!empty($dateTo[0])){
                $Gregorian = jDateTime::toGregorian($dateTo[0], $dateTo[1], $dateTo[2]);
                $dateTo = Carbon::createFromDate($Gregorian[0], $Gregorian[1], $Gregorian[2]);
                $model->whereHas('factor', function ($query) use ($dateTo) {
                    $query->where('created_at','<=',$dateTo);
                });
            }
        }


        $datatables = DataTables::eloquent($model)
            ->setRowAttr([
                'data-itemId' => function($model) {
                    return $model->id;
                }
            ])
            ->addColumn('image', function ($model) {
                return '<img src="'.$model->product->takeImage('main','58/0').'"/>';
            }, 1)
            ->addColumn('product_info', function ($model) {
                if($model->product->colors->find($model->color->id)->pivot->price != $model->product->colors->find($model->color->id)->pivot->price_discount){
                    return $model->product->brand->title."<br/>
                    <span class='boxed_color' title='".$model->color->title."' style='background-color: ".$model->color->code.";'></span> ".
                    $model->product->model."<br/>
                    <span class='price_old' data-mvwc>".$model->product->colors->find($model->color->id)->pivot->price."</span> - 
                    <span class='cl_green2' data-mvwc>".$model->product->colors->find($model->color->id)->pivot->price_discount."</span> تومان - 
                    <i class='cl_red'>".$model->product->colors->find($model->color->id)->pivot->discount."%</i>";
                } else {
                    return $model->product->brand->title."<br/>
                    <span class='boxed_color' title='".$model->color->title."' style='background-color: ".$model->color->code.";'></span> ".
                    $model->product->model."<br/>
                    <span class='cl_green2' data-mvwc>".$model->product->colors->find($model->color->id)->pivot->price_discount."</span> تومان" ;
                }
            }, 1)
            ->addColumn('total_quantity', function ($model) {
                return $model->total_quantity;
            }, 1)
            ->addColumn('total_price', function ($model) {
                return "<i data-mvwc>".$model->total_price."</i>";
            }, 1)
            ->escapeColumns([]);

        return $datatables->make(true);
    }
}
