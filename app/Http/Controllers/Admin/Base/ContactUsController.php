<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\ContactUs;

use DataTables;

class ContactUsController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'پیامهای تماس باما',"link" => route('admin.contact.index')]
        ];
        $header['list'] = ["title" => 'مدیریت پیامهای تماس باما',"description" => 'پیامهای تماس باما'];
        $data['contactUsMessages'] = ContactUs::all();
        return view('admin.pages.contactus.index', compact('items','header','data'));
    }


    public function store(Request $request)
    {
        ContactUs::create($request->all());
        return redirect()->back()->with('msg', __('contacts.add_item'));
    }

    public function edit($contact)
    {
        $contact = ContactUs::findorFail($contact);
        $contact->read = 0;
        $contact->save();

        $items = [
            ["title" => 'پیامهای تماس باما',"link" => route('admin.contact.index')],
            ["title" => 'خواندن پیام',"link" => "#"]
        ];

        $header['edit'] = ["title" => 'مدیریت پیامهای تماس باما',"description" => 'خواندن پیام'];
        return view('admin.pages.contactus.edit', compact('items','header','contact'));
    }

    function destroy(Request $request)
    {
        $ids = $request->get('ids');
        ContactUs::whereIn('id', $ids)->delete();
    }

    public function DataTable(Request $request)
    {
        $model = ContactUs::select(['id','name','created_at', 'read', 'position']);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}','data-read' => '{{$read}}'])
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
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.contactUs.edit',$model->id).'" class="btn_style3 blue"><i class="icon i-paperclip"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
