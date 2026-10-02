<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\User;

use Chat;
use Auth;
use DataTables;

class ChatController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => __('content.management_chat'),"link" => route('admin.chat.index')]
        ];

        $header['list'] = ["title" => __('content.management_chat'),"description" => __('content.list_of_chat')];
        $header['create'] = ["title" => __('content.management_chat'),"description" => __('content.create_chat')];

        $data['chats'] = Chat::conversations();
        $data['allUsers'] = User::where('role_id','>',2)->get();
        return view('admin.pages.chat.index', compact('items','header','data'));
    }

    public function show($conversation)
    {
        $conversation = Chat::conversationWithTrashed($conversation);
        $chats = Chat::conversations($conversation)->for(Auth::guard('admins')->user())->getMessages();
        foreach ($chats as $chat) {
            if($chat->user_id != Auth::guard('admins')->user()->id){
                Chat::messages($chat)->for($chat->sender)->markRead();
                Chat::messages($chat)->for(Auth::guard('admins')->user())->markRead();
            }
        }
        $chats = Chat::conversations($conversation)->for(Auth::guard('admins')->user())->getMessages();
        $items = [
            ["title" => __('content.management_chat'),"link" => route('admin.chat.index')],
            ["title" => __('content.show_chat') ,"link" => "#"]
        ];
        $header['show'] = ["title" => __('content.management_chat'),"description" => "مشاهده پیام ها "];
        return view('admin.pages.chat.show', compact('items','header','conversation','chats'));
    }

    public function store(Request $request)
    {
        if(Chat::getConversationBetween(Auth::guard('admins')->user()->id, $request->get('user_id'))){
            $conversation = Chat::getConversationBetween(Auth::guard('admins')->user()->id, $request->get('user_id')); 
            $message = Chat::message($request->get('body'))
                ->from(Auth::guard('admins')->user()->id)
                ->to($conversation)
            ->send();
        } else {
            $participants = [Auth::guard('admins')->user()->id, $request->get('user_id')];
            $conversation = Chat::createConversation($participants); 
            $message = Chat::message($request->get('body'))
                ->from(Auth::guard('admins')->user()->id)
                ->to($conversation)
            ->send();
        }

        return redirect()->back()->with('msg', 'پیام ثبت شد.');
    }

    public function update(Request $request,$conversation)
    {
        $conversation = Chat::conversation($conversation);
        $message = Chat::message($request->get('body'))
            ->from(Auth::guard('admins')->user()->id)
            ->to($conversation)
        ->send();
        return redirect()->back()->with('msg', 'پیام ثبت شد.');
    }

    function destroy(Request $request,$chat)
    {
        if($chat == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id) {
                $conversation = Chat::conversationWithTrashed($id);
                $users = $conversation->users;
                foreach ($users as $user) {
                    Chat::conversations($conversation)->for($user)->clear();
                    Chat::removeParticipants($conversation, $user);
                }
                $conversation->messages()->delete();
                $conversation->forceDelete();
            }
        } else {
            $conversation = Chat::conversationWithTrashed($chat);
            $users = $conversation->users;
            foreach ($users as $user) {
                Chat::conversations($conversation)->for($user)->clear();
                Chat::removeParticipants($conversation, $user);
            }
            $conversation->messages()->delete();
            $conversation->forceDelete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Chat::conversations()->for(Auth::guard('admins')->user())->dataTable();

        return DataTables::eloquent($model)
            ->setRowAttr([
                'data-itemId' => function($model) {
                    return $model->id;
                }
            ])
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->addColumn('userImage', function ($model) {
                return "<img width='50' src='".$model->users->where('id','<>',Auth::guard('admins')->user()->id)->first()->takeImage('avatar','50/50','user-avatar.jpg')."'>";
            }, 1)
            ->addColumn('users', function ($model) {
                return "نام کاربر: ".$model->users->where('id','<>',Auth::guard('admins')->user()->id)->first()->fullName()."<br/> شماره همراه: ".$model->users->where('id','<>',Auth::guard('admins')->user()->id)->first()->mobile;
            }, 1)
            ->editColumn('updated_at', function ($model) {
                return showAgoTime($model->last_message->updated_at);
            }, 1)
            ->addColumn('status', function ($model) {
                if(!$model->trashed()){
                    $readArray = array_column($model->getMessages(Auth::guard('admins')->user())->where('user_id','<>',Auth::guard('admins')->user()->id)->toArray(),'read_at');
                    $counts = count($readArray);
                    $filterCount = count(array_filter($readArray));
                    if($counts > $filterCount){$unreadCount = $counts - $filterCount;} else {$unreadCount =$filterCount - $counts;}
                    if($unreadCount > 0) {
                        return '<span class="cl_blue">'.$unreadCount.' پیام دارید</span>';
                    } else {
                        return '<span class="cl_green2">خوانده شده</span>';
                    }
                } else {
                    return '<span class="cl_red">حذف شده توسط کاربر</span>';
                }
            }, 1)
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.chat.show',$model->id).'" class="btn_style3 blue"><i class="icon i-paperclip"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
