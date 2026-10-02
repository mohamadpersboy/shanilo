<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\State;
use App\Models\Base\City;
use App\Models\Base\User;

use DataTables;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $data['objects'] = User::all();
        return view('admin.pages.user.index', compact('data'));
    }

    public function edit($user)
    {
        $user = User::find($user);
        $data['states'] = State::where('country_id', 1)->orderBy('name', 'asc')->get();
        return view('admin.pages.user.edit', compact('user', 'data'));
    }

    public function StateChange(Request $request)
    {
        $id = $request->get('id');
        $cities = City::where([['state_id', $id], ['display', 1]])->orderBy('name', 'asc')->get()->toArray();
        if (empty($cities)) {
            $cities = NULL;
        }
        return json_encode(array(
                'cities' => $cities,
            )
        );
    }

    public function update(Request $request, $user)
    {
        $update = User::find($user);

        // if($request->file('avatar') != null){
        //     if($update->attachments('avatar')->count()){
        //         $update->updateImage($request->file('avatar'), 'avatar',$request->get('cropper_avatar'));
        //     } else {
        //         $update->createImage($request->file('avatar'), 'avatar',$request->get('cropper_avatar'));
        //     }
        // }

        if ($request->input('password') != null) {
            $this->validate($request, [
                'password' => 'required|confirmed|min:6',
            ]);
            $password = $request->input('password');
        } else {
            $password = $update->password;
        }

        $request->request->add(['password' => $password]);
        $update->update($request->all());
        return redirect()->back()->with('msg', __('messages.edit_item'));
    }

    function destroy(Request $request, $user)
    {
        $users = User::find($request->get('ids'));
        foreach ($users as $index => $user) {
            $user->delete();
        }
    }

    public function export(Request $request)
    {
        $newsletters = User::select('email')->get();
        $time = time();
        Excel::create('user-' . $time, function ($excel) use ($newsletters) {
            $excel->sheet('TestSheet', function ($sheet) use ($newsletters) {
                // Our first sheet
                $sheet->fromArray($newsletters, null, 'A1', false, false)
                    ->prependRow(1, array(
                        __('content.tbl_email'),
                    ))->setStyle(array(
                        'font' => array(
                            'name' => 'Tahoma',
                            'size' => 12,
                            'bold' => false
                        )
                    ));
            });
        })->export('xlsx');

        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function DataTable(Request $request)
    {
        $model = User::query()->whereNotIn('role_id', [1, 2]);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';

            }, 1)
            ->editColumn('name', function ($model) {
                return getUsersFullName($model);
            }, 1)
            ->addColumn('login', function ($model) {
                if (\Auth::guard('admins')->user()->hasRole('atlas-administrator') || \Auth::guard('admins')->user()->hasRole('administrator')) {
                    return '<a href="' . route('admin.user.loginas', $model->id) . '" style="color: #4183ff" target="_blank"><i class="glyphicon glyphicon-log-in"></i></a>';
                }
            }, 1)
            ->editColumn('confirmed_by_admin', function ($model) {
                return $model->confirmed_by_admin ? "<span class='icon-check'></span>" : "";
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->addColumn('type_change', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="' . $model->id . '"
                           data-model="' . get_class($model) . '"
                           data-database="mysql"
                           data-link="' . route('admin.user.change-type', $model->id) . '"
                           value="1" ' . ($model->type == 'legal' ? 'checked="checked"' : '') . ' >
                        </label>';
            })
            ->addColumn('edit', function ($model) {
                return '<a href="' . route('admin.user.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /******************************/
    //Specific
    /******************************/
    public function loginAs(User $user)
    {
        if ($user->id == 1) {
            abort(404);
        }

        \Auth::login($user);

//        session(['front-login' => $user]);

        return redirect()->route('front.profile.index');
    }

    public function changeType(Request $request, User $user)
    {

        if ($switchy = $request->get('switchy')) {
            $user->update(['type' => 'legal']);
        } else {
            $user->update(['type' => 'real']);
        }
    }


}
