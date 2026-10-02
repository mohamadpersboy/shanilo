<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Base\PermissionRequest;
use App\Models\Base\SiteRoute;

use DataTables;

class PermissionController extends Controller
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
            ["title" => __('content.management_permissions'),"link" => route('admin.permission.index')]
        ];

        $header['list'] = ["title" => __('content.management_permissions'),"description" => __('content.list_of_permission')];

        $data['permissions'] = SiteRoute::all();
        return view('admin.pages.permission.index', compact('items','header','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_permissions'),"link" => route('admin.permission.index')],
            ["title" => __('content.create_permission'),"link" => route('admin.permission.create')]
        ];

        $header['create'] = ["title" => __('content.management_permissions'),"description" => __('content.create_permission')];

        return view('admin.pages.permission.create', compact('items','header','data')); 
    }

    public function store(PermissionRequest $request)
    {
        $slugs = $request->get('slug');
        $slugs = explode(',',$slugs);
        $new_slugs = array();
        foreach($slugs as $slug){
            $new_slugs[trim($slug)]=true;
        }
        $create = SiteRoute::create([
            "name" => $request->get('name'),
            "slug" => $new_slugs,
        ]);
        return redirect()->route('admin.permission.edit',$create->id)->with('msg', __('messages.add_item'));
    }

    public function edit($permission)
    {
        $permission = SiteRoute::findorFail($permission);

        $items = [
            ["title" => __('content.management_permissions'),"link" => route('admin.permission.index')],
            ["title" => __('content.edit_permission'),"link" => "#"]
        ];

        $header['edit'] = ["title" => __('content.management_permissions'),"description" => __('content.edit_permission')];
        
        return view('admin.pages.permission.edit', compact('items','header','data','permission'));
    }

    public function update(PermissionRequest $request, $permission)
    {
        $update = SiteRoute::findorFail($permission);
        $slugs = $request->get('slug');
        $slugs = explode(',',$slugs);
        $new_slugs = array();
        foreach($slugs as $slug){
            $new_slugs[trim($slug)]=true;
        }
        $update->update([
            "name" => $request->get('name'),
            "slug" => "",
        ]);
        $update->update([
            "name" => $request->get('name'),
            "slug" => $new_slugs,
        ]);
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$permission)
    {
        if($permission == "all"){
            $ids = $request->get('ids');
            SiteRoute::whereIn('id', $ids)->delete();
        } else {
            SiteRoute::find($permission)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = SiteRoute::select(['id','name','created_at', 'updated_at']);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.permission.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
