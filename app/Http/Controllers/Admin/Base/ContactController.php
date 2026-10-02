<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Requests\Admin\Base\ContactRequest;
use App\Models\Base\Contact;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'اطلاعات تماس', "link" => route('admin.contact.index')]
        ];
        $data = [
            'items' => $items,
            'contacts' => Contact::count()
        ];
        return view('admin.pages.contact.index', $data);
    }

    public function create()
    {
        $items = [
            ["title" => 'ایجاد اطلاعات تماس', "link" => route('admin.contact.create')]
        ];
        $data = [
            'items' => $items,
        ];

        return view('admin.pages.contact.create', $data);
    }

    public function store(ContactRequest $request)
    {
        Contact::create($request->all());
        return back()->with('msg', __('messages.add_item'));
    }

    public function edit(Contact $contact)
    {
        $items = [
            ["title" => 'نمایش اطلاعات تماس باما', "link" => route('admin.contact.index')],
            ["title" => $contact->title, "link" => route('admin.contact.edit', $contact)],
        ];
        $data = [
            'items' => $items,
            'edit'=>true,
            'contact'=>$contact
        ];
        return view('admin.pages.contact.edit', $data);
    }

    public function update(ContactRequest $request,Contact $contact)
    {
        $main=$request->input('main')?1:0;
        $request->merge(['main'=>$main]);
        $contact->update($request->all());
        return back()->with('msg', __('messages.edit_item'));
    }

    public function destroy(Request $request,$contact)
    {
        $contacts=Contact::find($request->input('ids'));
        foreach ($contacts as $contact){
            $contact->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Contact::query();
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
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="' . $model->id . '"
                           data-model="' . get_class($model) . '"
                           data-database="mysql"
                           data-link="' . route('admin.switch.update', $model->id) . '"
                           value="1" ' . ($model->display == 1 ? 'checked="checked"' : '') . ' >
                        </label>';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="' . route('admin.contact.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
