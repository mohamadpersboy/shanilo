<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Events\MessageSent;
use App\Models\Base\User;
use App\Models\Specific\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class MessageController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت پیامهای کاربران', "link" => route('admin.message.index')]
        ];
        $data = [
            'items' => $items,
            'messages' => Message::parents()->where('receiver_id', null)->orWhere('user_id', null)->count()
        ];
        return view('admin.specific.message.index', $data);
    }

    public function show(Message $message)
    {
        $items = [
            ["title" => 'مدیریت پیامهای کاربران', "link" => route('admin.message.index')],
            ["title" => 'نمایش جزئیات پیام', "link" => route('admin.message.show',$message)],
        ];
        $messages=$message->children->push($message)->reverse();
        $messages->each(function (Message $message){
            if($message->receiver_id==null){
                $message->update(['is_read'=>1]);
            }
        });
        $data = [
            'items' => $items,
            'messages' =>$messages,
            'receiverId'=>$message->receiver_id?:$message->user_id
        ];
        return view('admin.specific.message.show',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'receiver_id'=>'required|exists:users,id',
            'message'=>'required'
        ],[],[
            'message'=>'پیام'
        ]);
        $receiver = User::findOrFail($request->get('receiver_id'));
        if ($parentMessage=auth('admins')->user()->hasCommunicatedBefore($receiver)){
            $request->merge(['parent_id'=>$parentMessage->id]);
        }
        $message=Message::create($request->all());
        event(new MessageSent($message));
        return back()->with('msg','پیام شما با موفقیت ارسال شد.');
    }

    public function destroy(Request $request, $message)
    {
        $messages = Message::find($request->input('ids'));
        foreach ($messages as $index => $message) {
            $message->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Message::parents()->where(function (Builder $builder) {
            $builder->where('user_id',null)
                ->orWhere('receiver_id',null);
        })->orderBy('is_read')->orderBy('created_at','desc');
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->editColumn('id', function ($model) {
                return !$model->receiver_id && !$model->is_read?'<span class="label label-info">جدید</span>':'-';
            }, 1)
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->editColumn('receiver_id', function ($model) {
                return $model->receiver_id?getUsersFullName($model->receiver):'پشتیبانی';
            }, 1)
            ->editColumn('user_id', function ($model) {
                return $model->user_id?getUsersFullName($model->sender):'پشتیبانی';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="' . route('admin.message.show', $model->id) . '" class="btn_style3 blue"><i class="icon i-paperclip"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
