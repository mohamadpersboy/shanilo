<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\AdminBank;
use App\Http\Requests\Admin\Base\BankRequest;

use DataTables;

class BankController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_bank'),"link" => route('admin.bank.index')]
        ];
        $data['objects'] = AdminBank::all();
        return view('admin.pages.bank.index', compact('items','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_bank'),"link" => route('admin.bank.index')],
            ["title" => __('content.create_bank'),"link" => route('admin.bank.create')]
        ];
        return view('admin.pages.bank.create',compact('items'));
    }

    public function store(BankRequest $request)
    {
        $this->validate($request, [
            'pic' => 'required',
        ],[],[
            'pic' => 'آیکون بانک',
        ]);
        $request->request->add(['admin_id' => \Auth::guard('admins')->user()->id]);
        $create = AdminBank::create($request->all());
        $create->createImage($request->file('pic'), 'main');
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($bank)
    {
        $bank = AdminBank::find($bank);
        $items = [
            ["title" => __('content.management_bank'),"link" => route('admin.bank.index')],
            ["title" => $bank->title,"link" => "#"]
        ];
        return view('admin.pages.bank.edit', compact('items','bank'));
    }

    public function update(BankRequest $request, $bank)
    {
        $update = AdminBank::find($bank);
        if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main');
        }
        AdminBank::find($bank)->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$bank)
    {
        if($bank == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                AdminBank::find($id)->delete();
            }
        } else {
            AdminBank::find($bank)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = AdminBank::select(['id','title','name','created_at', 'updated_at','display', 'position']);
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
                return '<a href="'.route('admin.bank.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
