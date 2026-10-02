<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Kodeine\Acl\Models\Eloquent\Role;
use App\Models\Base\SiteRoute;
use App\Http\Requests\Admin\Base\RoleRequest;

use Auth;
use DataTables;

class RoleController extends Controller
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
            ["title" => __('content.management_roles'),"link" => route('admin.role.index')]
        ];

        $header['list'] = ["title" => __('content.management_roles'),"description" => __('content.list_of_role')];

        if (Auth::guard('admins')->user()->role_id == 1) {
            $data['roles'] = Role::all();
        } else {
            $data['roles'] = Role::where('slug','<>','atlas-administrator')->get();
        }
        return view('admin.pages.role.index', compact('items','header','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_roles'),"link" => route('admin.role.index')],
            ["title" => __('content.create_role'),"link" => route('admin.role.create')]
        ];

        $header['create'] = ["title" => __('content.management_roles'),"description" => __('content.create_role')];

        $data['permissions'] = SiteRoute::all();
        return view('admin.pages.role.create', compact('items','header','data'));
    }


    public function store(RoleRequest $request)
    {
        $request->request->add(['slug' => removeSpecialChar(strtolower(trim($request->get('slug'))))]);
        $create = Role::create($request->all());
        foreach($request->get('add_permission') as $perm){
            $create->addPermission($perm, true);
        }
        return redirect()->route('admin.role.edit',$create->id)->with('msg', __('messages.add_item'));
    }

    public function edit($role)
    {
        $role = Role::findorFail($role);

        $items = [
            ["title" => __('content.management_roles'),"link" => route('admin.role.index')],
            ["title" => $role->name,"link" => "#"]
        ];

        $header['edit'] = ["title" => __('content.management_roles'),"description" => __('content.edit_role')];

        $data['permissions'] = SiteRoute::all();
        return view('admin.pages.role.edit', compact('items','header','data','role'));
    }

    public function update(Request $request, $role)
    {
        if($request->has('name') || $request->has('slug')){
            return redirect()->back()->with('err','Do not Do that');
        }
        $update = Role::findorFail($role);
        $update->update($request->all());
        if($request->get('remove_permission') !== null){
            foreach($request->get('remove_permission') as $uperm){
                $update->removePermission($uperm);
            }
        }
        if($request->get('add_permission') !== null) {
            foreach ($request->get('add_permission') as $perm) {
                $update->addPermission($perm, true);
            }
        }
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$role)
    {
        if($role == "all"){
            $ids = $request->get('ids');
            Role::whereIn('id', $ids)->delete();
        } else {
            Role::find($role)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        if (Auth::guard('admins')->user()->role_id == 1) {
            $model = Role::select(['id','name','created_at', 'updated_at', 'position']);
        } else {
            $model = Role::select(['id','name','created_at', 'updated_at', 'position'])->where('slug','<>','atlas-administrator');
        }
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
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.role.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
