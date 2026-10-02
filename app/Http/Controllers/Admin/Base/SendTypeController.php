<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\City;
use App\Models\Base\State;
use App\Models\Base\SendType;
use App\Http\Requests\Admin\Base\SendTypeRequest;

use DataTables;

class SendTypeController extends Controller
{
    public function index()
    {

        $items = [
            ["title" => __('content.management_send_type'),"link" => route('admin.send_type.index')]
        ];
        $data['objects'] = SendType::visible()->orderBy('position')->get();
        $data['states'] = State::where('country_id',1)->orderBy('name','asc')->get();
        return view('admin.pages.send_type.index', compact('items','data'));
    }

    public function ChangeContent(Request $request)
    {
        $description = explode(',',$request->get('description'));
        $free_from = explode(',',$request->get('free_from'));
        $send_type_id = explode(',',$request->get('send_type_id'));

        $i = 0;
        foreach ($send_type_id as $send_type){
            SendType::find($send_type_id[$i])->update([
                'description' => $description[$i],
                'free_from' => $free_from[$i],
            ]);
            $i++;
        }
    }

    public function ShowState(Request $request)
    {
        $send_type_id = $request->get('send_type_id');
        $cities = City::whereHas('send_types', function ($query) use ($send_type_id) {
            $query->where('id', $send_type_id);
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

        $thead = '<tr><th class="width10"><i class="icon1 i-list-ol"></i></th><th class="width10"><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row1"><span class="box"></span></label></th><th class="width40">استان</th><th class="width20"><input type="text" name="price_all" value="" class="tcenter input1 number_format letter1" placeholder="هزینه - تومان" style="width:100px;background:#e8f6ff;"></th></tr>';
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
        $send_type_id = $request->get('send_type_id');
        $prices = explode(',',$request->get('prices'));
        $states = explode(',',$request->get('states'));
        $statesid = explode(',',$request->get('statesid'));

        $send_type = SendType::find($send_type_id);
        $i = 0;
        $id_array = [];
        $statesid_array = [];
        $prices_array = [];
        foreach ($states as $state){
            if($states[$i] != 0){
                array_push($statesid_array,$statesid[$i]);
                $prices_array[$statesid[$i]] = $prices[$i];
            }
            $i++;
        }

        $cities = City::whereIn('state_id', $statesid_array)->get();
        $send_type->cities()->detach();
        foreach ($cities as $city){
            $send_type->cities()->attach($city->id, ['price' => $prices_array[$city->state_id]]);
        }
    }

    public function StateChange(Request $request)
    {
        $state_id = $request->get('state_id');
        $send_type_id = $request->get('send_type_id');
        $state = State::find($state_id);
        $cities = City::with('send_types')->where([['state_id',$state_id],['display',1]])->orderBy('name','asc')->get()->toArray();
        $thead = '<tr><th class="width10"><i class="icon1 i-list-ol"></i></th><th class="width10"><label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row1"><span class="box"></span></label></th><th class="width40">شهرهای استان '.$state->name.'</th><th class="width20"><input type="text" name="price_all" value="" class="tcenter input1 number_format letter1" placeholder="هزینه - تومان" style="width:100px;background:#e8f6ff;"></th></tr>';
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
        $send_type_id = $request->get('send_type_id');
        $prices = explode(',',$request->get('prices'));
        $cities = explode(',',$request->get('cities'));
        $citiesid = explode(',',$request->get('citiesid'));

        $send_type = SendType::find($send_type_id);
        $i = 0;
        foreach ($cities as $city){
            if($cities[$i] == 0){
                $send_type->cities()->detach($citiesid[$i]);
            } else {
                $send_type->cities()->detach($citiesid[$i]);
                $send_type->cities()->attach($citiesid[$i], ['price' => $prices[$i]]);
            }
            $i++;
        }
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_send_type'),"link" => route('admin.send_type.index')],
            ["title" => __('content.create_send_type'),"link" => route('admin.send_type.create')]
        ];
        return view('admin.pages.send_type.create',compact('items'));
    }


    public function store(SendTypeRequest $request)
    {
       /* $this->validate($request, [
            'pic' => 'required',
        ],[],[
            'pic' => 'آیکون',
        ]);*/
        $request->request->add(['price' => str_replace(',','',$request->get('price'))]);
        $request->request->add(['free_from' => str_replace(',','',$request->get('free_from'))]);
        $create = SendType::create($request->all());
      //  $create->createImage($request->file('pic'), 'main',$request->get('cropper'));
        return redirect()->route('admin.send_type.edit',$create->id)->with('msg', __('messages.add_item'));
    }

    public function edit($send_type)
    {
        $send_type = SendType::find($send_type);
        $items = [
            ["title" => __('content.management_send_type'),"link" => route('admin.send_type.index')],
            ["title" => $send_type->title,"link" => "#"]
        ];
        return view('admin.pages.send_type.edit', compact('items','send_type'));
    }

    public function update(SendTypeRequest $request, $send_type)
    {
        $update = SendType::find($send_type);
       /* if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main',$request->get('cropper'));
        }*/
        $request->request->add(['price' => str_replace(',','',$request->get('price'))]);
        $request->request->add(['free_from' => str_replace(',','',$request->get('free_from'))]);
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$send_type)
    {
        if($send_type == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                SendType::find($id)->delete();
            }
        } else {
            SendType::find($send_type)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = SendType::select(['id','title','display','created_at', 'updated_at', 'position']);
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
                return '<a href="'.route('admin.send_type.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
