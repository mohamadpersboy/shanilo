<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Ticket;
use App\Models\Base\User;

use DataTables;

class TicketController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => __('content.management_ticket'),"link" => route('admin.ticket.index')]
        ];

        $header['list'] = ["title" => __('content.management_ticket'),"description" => __('content.list_of_ticket')];

        $data['tickets'] = Ticket::all();
        $data['users'] = User::whereHas('tickets')->get();
        return view('admin.pages.ticket.index', compact('items','header','data'));
    }

    public function show($ticket)
    {
        $ticket = Ticket::withTrashed()->findOrFail($ticket);
        $ticket->update(['seenStatus'=>1]);
        $items = [
            ["title" => __('content.management_ticket'),"link" => route('admin.ticket.index')],
            ["title" => $ticket->title ,"link" => "#"]
        ];
        $header['show'] = ["title" => __('content.management_ticket'),"description" => "مشاهده تیکت شماره ".$ticket->code];
        return view('admin.pages.ticket.show', compact('items','header','ticket'));
    }

    public function store(Request $request)
    {
        $parentTicket = Ticket::find($request->get('parent_id'));
        if($parentTicket){
            $request->request->add(['status' => 2]);
            $request->merge(['seenStatus'=>3]);
            $create = Ticket::create($request->all());
            $parentTicket->updated_at = $create->updated_at;
            $parentTicket->status = 2;
            $parentTicket->save();
            return redirect()->back()->with('msg', __('tickets.add_item'));
        } else {
            return redirect()->back()->with('err', 'لطفا مجددا تلاش کنید.');
        }
    }

    function destroy(Request $request,$ticket)
    {
        if($ticket == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id) {
                $ticket = Ticket::withTrashed()->find($id);
                if ($ticket->trashed()) {
                    $ticket->tickets()->forceDelete();
                    $ticket->forceDelete();
                } else {
                    $ticket->delete();
                }
            }
        } else {
            $ticket = Ticket::withTrashed()->find($ticket);
            if ($ticket->trashed()) {
                $ticket->tickets()->forceDelete();
                $ticket->forceDelete();
            } else {
                $ticket->delete();
            }
        }
    }

    public function DataTable(Request $request)
    {
        $model = Ticket::select(['id','title','user_id','status','code','priority','created_at','updated_at','deleted_at']);
        if($status = $request->get('status')) {
            if($status == 4){
                $model->withTrashed()->where('parent_id',null);
            } else {
                if($status == 99){
                    $model->onlyTrashed()->where('parent_id',null);
                } else {
                    $model->where('parent_id',null)->where('status',$status);
                }
            }
        } else {
            $model->where('parent_id',null)->where('status',1);
        }

        if ($user_id = $request->get('user_id')) {
            $model->where('user_id', $user_id);
        }

        if ($code = $request->get('code')) {
            $model->where('code', $code);
        }

        if ($priority = $request->get('priority')) {
            $model->where('priority', $priority);
        }

        return DataTables::eloquent($model)
            ->setRowAttr([
                'data-itemId' => function($model) {
                    return $model->id;
                },
                'data-status' => function($model) {
                    return $model->status;
                },
            ])
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->editColumn('user_id', function ($model) {
                return "نام کاربر: ".getUsersFullName($model->user)."<br/>"." شماره همراه: ".$model->user->mobile;
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->editColumn('priority', function ($model) {
                if($model->priority == 1) {
                    return '<span class="cl_green">پایین</span>';
                } elseif($model->priority == 2){
                    return '<span class="cl_green">متوسط</span>';
                } else {
                    return '<span class="cl_green">فوری و مهم</span>';
                }
            }, 1)
            ->editColumn('status', function ($model) {
                if($model->deleted_at != null){
                    return '<span class="cl_red">حذف شده</span>';
                } else {
                    if($model->status == 1) {
                        return '<span class="cl_blue">در انتظار پاسخ</span>';
                    } elseif($model->status == 2){
                        return '<span class="cl_green2">پاسخ داده شده</span>';
                    }
                }
            }, 1)
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.ticket.show',$model->id).'" class="btn_style3 blue"><i class="icon i-paperclip"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
