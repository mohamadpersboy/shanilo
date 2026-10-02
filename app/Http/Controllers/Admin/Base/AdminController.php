<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Base\ProfileRequest;
use Kodeine\Acl\Models\Eloquent\Role;

use App\Models\Base\User;

use Auth;
use DataTables;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (\Session::get('lang') != null){
                \App::setLocale(\Session::get('lang'));
            }
            \Config::set('database.default',"mysql");
            return $next($request);
        });
    }

    public function index()
    {
        $items = [
            ["title" => __('content.management_admins'),"link" => route('admin.admin.index')]
        ];

        $header['list'] = ["title" => __('content.management_admins'),"description" => __('content.list_of_admin')];

        if (Auth::guard('admins')->user()->role_id == 1) {
            $data['admins'] = User::where('role_id','<', 3)->get();
        } else {
            $data['admins'] = User::where('role_id', 2)->get();
        }
        return view('admin.pages.admin.index', compact('items','header','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_admins'),"link" => route('admin.admin.index')],
            ["title" => __('content.create_admin'),"link" => route('admin.admin.create')]
        ];

        $header['create'] = ["title" => __('content.management_admins'),"description" => __('content.create_admin')];

        if (Auth::guard('admins')->user()->role_id == 1) {
            $data['roles'] = Role::all();
        } else {
            $data['roles'] = Role::where('slug','<>','atlas-administrator')->get();
        }
        return view('admin.pages.admin.create', compact('items','header','data'));
    }


    public function store(ProfileRequest $request)
    {
        $create = User::create([
            'name' => $request->input('name'),
            'family' => $request->input('family'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'uid'=>str_random(10)
        ]);

        $create->role_id = 2;
        $create->save();

        $create->syncRoles($request->get('role'));

        if ($request->file('main_image') !== null && $request->file('main_image') != null){
            $create->createImage($request->file('main_image'), 'main',null,['50/50']);
        }
        return redirect()->route('admin.admin.index')->with('msg', __('messages.add_item'));
    }

    public function edit($admin)
    {
        $data['admin'] = User::findorFail($admin);

        $items = [
            ["title" => __('content.management_admins'),"link" => route('admin.admin.index')],
            ["title" => getUsersFullName($data['admin']),"link" => "#"]
        ];

        $header['edit'] = ["title" => __('content.management_admins'),"description" => __('content.edit_admin')];

        if (Auth::guard('admins')->user()->role_id == 1) {
            $data['roles'] = Role::all();
        } else {
            $data['roles'] = Role::where('slug','<>','atlas-administrator')->get();
        }

        return view('admin.pages.admin.edit', compact('items','header','data'));
    }

    public function update(Request $request,$admin)
    {
        $update = User::findorFail($admin);
        if($request->file('main_image') !== null && $request->file('main_image') != null){
            $update->updateImage($request->file('main_image'), 'main',null,['50/50']);
        }
        if($request->input('password') != null){
            $password = $request->input('password');
        } else {
            $password = $update->password;
        }
        if(!empty($request->get('role'))){
            $update->syncRoles($request->get('role'));
        }
        $update->update([
            'name' => $request->input('name'),
            'family' => $request->input('family'),
            'email' => $request->input('email'),
            'password' => $password,
        ]);
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    public function changePassword(Request $request)
    {
        $admin = Auth::guard('admins')->user();
        if (\Hash::check($request->get('current_password'), $admin->getAuthPassword())) {
            if($admin->email == $request->get('email')){
                $this->validate($request, [
                    'current_password' => 'required',
                    'password' => 'required|confirmed|min:6',
                ]);
                $admin->update([
                    'password' =>$request->get('password'),
                ]);
            } else {
                $this->validate($request, [
                    'email' => 'required|email|unique:admins',
                    'current_password' => 'required',
                    'password' => 'required|confirmed|min:6',
                ]);
                $admin->update([
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                ]);
            }
            return redirect()->back()->with('msg', __('messages.password_changed'));
        } else {
            return redirect()->back()->with('err', __('messages.password_not_changed'));
        }
    }

    function destroy(Request $request,$admin)
    {
        if($admin == "all"){
            $ids = $request->get('ids');
            User::whereIn('id', $ids)->delete();
        } else {
            User::find($admin)->delete();
        }
    }

    public function DataTable(Request $request)
    {

        if (\Auth::guard('admins')->user()->role_id == 1) {
            $model = User::select(['id','name','family','created_at', 'updated_at', 'status'])->where('role_id','<', 3);
        } else {
            $model = User::select(['id','name','family','created_at', 'updated_at', 'status'])->where('role_id', 2);
        }
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('check', function ($model) {
                if(in_array('2',array_column($model->roles->toArray(),'id')) || in_array('1',array_column($model->roles->toArray(),'id'))){
                    return "";
                } else {  
                    return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
                }
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->editColumn('status', function ($model) {
                if(in_array('2',array_column($model->roles->toArray(),'id')) || in_array('1',array_column($model->roles->toArray(),'id'))){
                    return "";
                } else {
                    return '<label class="checkradio_style2 switchery-sm"><input name="status" type="checkbox" class="js-switch switch_for_all"
                           data-id="'.$model->id.'"
                           data-model="'.get_class($model).'"
                           data-database="mysql"
                           data-link="'.route('admin.switch.update',$model->id).'"
                           value="1" '.($model->status == 1 ? 'checked="checked"':'').' >
                        </label>';
                }
            }, 1)
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.admin.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
