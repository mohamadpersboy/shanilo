<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\City;
use App\Models\Base\State;
use App\Models\Base\PayType;
use App\Http\Requests\Admin\Base\PaytypeRequest;

use DataTables;

class PayTypeController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => __('content.management_pay_type'),"link" => route('admin.pay_type.index')]
        ];
        $data['objects'] = Paytype::visible()->orderBy('position')->get();
        $data['states'] = State::where('country_id',1)->orderBy('name')->get();
        return view('admin.pages.pay_type.index', compact('items','data'));
    }

    public function ChangeContent(Request $request)
    {
        $description = explode(',',$request->get('description'));
        $price_max = explode(',',$request->get('price_max'));
        $pay_type_id = explode(',',$request->get('pay_type_id'));

        $i = 0;
        foreach ($pay_type_id as $pay_type){
            Paytype::find($pay_type_id[$i])->update([
                'description' => $description[$i],
                'price_max' => $price_max[$i],
            ]);
            $i++;
        }
    }

    public function ShowState(Request $request)
    {
        $pay_type_id = $request->get('pay_type_id');
        $cities = City::whereHas('pay_types', function ($query) use ($pay_type_id) {
            $query->where('id', $pay_type_id);
        })->select('state_id')->groupBy('state_id')->get()->toArray();
        $states = State::where('country_id',1)->orderBy('name','asc')->get()->toArray();
        $i=0;
        foreach ($states as $state){
            if(in_array($states[$i]['id'],array_column($cities,'state_id'))){
                $states[$i]['city_status'] = 1;
            } else {
                $states[$i]['city_status'] = 0;
            }
            $i++;
        }

//        $thead = '<tr><th class="width10"><i class="icon1 i-list-ol"></i></th><th class="width10"><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row1"><span class="box"></span></label></th><th class="width40">استان</th><th class="width20"><input type="text" name="price_all" value="" class="tcenter input1 number_format letter1" placeholder="هزینه - تومان" style="width:100px;background:#e8f6ff;"></th></tr>';
        $thead = '<tr><th class="width10"><i class="icon1 i-list-ol"></i></th><th class="width10"><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row1"><span class="box"></span></label></th><th class="width40">استان</th></tr>';
        if(empty($states)){
            $states = NULL;
        }
        return json_encode(array(
                'thead' => $thead,
                'states' => $states,
            )
        );
    }

    public function StatePrice(Request $request)
    {
        $pay_type_id = $request->get('pay_type_id');
//        $prices = explode(',',$request->get('prices'));
        $states = explode(',',$request->get('states'));
        $statesid = explode(',',$request->get('statesid'));

        $pay_type = Paytype::find($pay_type_id);
        $i = 0;
        $id_array = [];
        $statesid_array = [];
        $prices_array = [];
        foreach ($states as $state){
            if($states[$i] != 0){
                array_push($statesid_array,$statesid[$i]);
//                $prices_array[$statesid[$i]] = $prices[$i];
            }
            $i++;
        }

        $cities = City::whereIn('state_id', $statesid_array)->get();
        $pay_type->cities()->detach();
        foreach ($cities as $city){
//            $pay_type->cities()->attach($city->id, ['price' => $prices_array[$city->state_id]]);
            $pay_type->cities()->attach($city->id);
        }
    }

    public function StateChange(Request $request)
    {
        $state_id = $request->get('state_id');
        $pay_type_id = $request->get('pay_type_id');
        $state = State::find($state_id);
        $cities = City::with('pay_types')->where([['state_id',$state_id],['display',1]])->orderBy('name','asc')->get()->toArray();
//        $thead = '<tr><th class="width10"><i class="icon1 i-list-ol"></i></th><th class="width10"><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row1"><span class="box"></span></label></th><th class="width40">شهرهای استان '.$state->name.'</th><th class="width20"><input type="text" name="price_all" value="" class="tcenter input1 number_format letter1" placeholder="هزینه - تومان" style="width:100px;background:#e8f6ff;"></th></tr>';
        $thead = '<tr><th class="width10"><i class="icon1 i-list-ol"></i></th><th class="width10"><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row1"><span class="box"></span></label></th><th class="width40">شهرهای استان '.$state->name.'</th></tr>';
        if(empty($cities)){
            $cities = NULL;
        }
        return json_encode(array(
                'thead' => $thead,
                'cities' => $cities,
            )
        );
    }

    public function CityPrice(Request $request)
    {
        $pay_type_id = $request->get('pay_type_id');
//        $prices = explode(',',$request->get('prices'));
        $cities = explode(',',$request->get('cities'));
        $citiesid = explode(',',$request->get('citiesid'));

        $pay_type = Paytype::find($pay_type_id);
        $i = 0;
        foreach ($cities as $city){
            if($cities[$i] == 0){
                $pay_type->cities()->detach($citiesid[$i]);
            } else {
                $pay_type->cities()->detach($citiesid[$i]);
//                $pay_type->cities()->attach($citiesid[$i], ['price' => $prices[$i]]);
                $pay_type->cities()->attach($citiesid[$i]);
            }
            $i++;
        }
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_pay_type'),"link" => route('admin.pay_type.index')],
            ["title" => __('content.create_pay_type'),"link" => route('admin.pay_type.create')]
        ];
        return view('admin.pages.pay_type.create',compact('items'));
    }


    public function store(PaytypeRequest $request)
    {
       /* $this->validate($request, [
            'pic' => 'required',
        ],[],[
            'pic' => 'آیکون',
        ]);*/
        $request->request->add(['price_max' => str_replace(',','',$request->get('price_max'))]);
        $create = Paytype::create($request->all());
      /*  $create->createImage($request->file('pic'), 'main',$request->get('cropper'));*/
        return redirect()->route('admin.pay_type.edit',$create->id)->with('msg', __('messages.add_item'));
    }

    public function edit($pay_type)
    {
        $pay_type = Paytype::find($pay_type);
        $items = [
            ["title" => __('content.management_pay_type'),"link" => route('admin.pay_type.index')],
            ["title" => $pay_type->title,"link" => "#"]
        ];
        return view('admin.pages.pay_type.edit', compact('items','pay_type'));
    }

    public function update(PaytypeRequest $request, $pay_type)
    {
        $update = Paytype::find($pay_type);
        /*if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main',$request->get('cropper'));
        }*/
        $request->request->add(['price_max' => str_replace(',','',$request->get('price_max'))]);
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$pay_type)
    {
        if($pay_type == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                Paytype::find($id)->delete();
            }
        } else {
            Paytype::find($pay_type)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Paytype::select(['id','title','display','created_at', 'updated_at', 'position']);
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
                return '<a href="'.route('admin.pay_type.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
