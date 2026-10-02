<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\Base\ProfileController;
use App\Http\Requests\Front\User\TicketRequest;
use App\Models\Specific\Message;
use App\Models\Base\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Base\User;


class MessageController extends ProfileController
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Messages
    # Handles message operations in front user profile
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function index()
    {
        $user = \Auth::user();

        $data = [
            'user' => $user,
            'activeMenu' => 'messages',
            'shops'=>auth()->user()->shops()->get(),
            'unreadTickets' => $user->tickets()->unRead()->where('receiver_id', $user->id)->count()
        ];

        return view('front.pages.profile.message.index', $data);
    }

    public function show(Message $message)
    {
        $this->checkIfMessageIsShowable($message);
        $user = \Auth::user();
        $data = [
            'pageTitle' => 'نمایش جزئیات پیام',
            'user' => $user,
            'messages' => $message->children->push($message),
            'activeMenu' => 'messages',
            'parentMessage' => $message,
            'id'=>request()->route()->parameter('message')->id
        ];
        $data['messages']->each(function ($message) {
            if ($message->receiver_id == auth()->id()) {
                $message->update(['is_read' => 1]);
            }
        });
        $data['messages'] = $data['messages']->reverse();

        return view('front.pages.profile.message.show', $data);
    }

    public function tickets()
    {
        $user = \Auth::user();
        $data = [
            'ticket' => true,
            'pageTitle' => 'نمایش جزئیات پیام',
            'user' => $user,
            'messages' => auth()->user()->tickets()->latest()->get(),
            'activeMenu' => 'messages',
        ];
        $data['messages']->each(function ($message) {
            if ($message->receiver_id == auth()->id()) {
                $message->update(['is_read' => 1]);
            }
        });
        $data['messages'] = $data['messages']->reverse();
        return view('front.pages.profile.message.show', $data);
    }

    public function storeTicket(Request $request)
    {
        $this->validate($request, [
            'message' => 'required_without_all:upload_file',
            'upload_file' => 'nullable|max:6000',
        ], [
            'message.required_without_all' => 'حداقل یکی از فیلد های پیام یا فایل باید اطلاعات داشته باشد ',
            'upload_file.max' => 'فایل انتخابی نمی تواند بیشتر از 5 مگاباspeیت باشد '
        ]);
        $request->merge(['user_id' => auth()->id()]);
        if ($parentMessage = auth()->user()->hasCommunicatedBefore(null)) {
            $request->merge(['parent_id' => $parentMessage->id]);
        }
        Message::create($request->all());
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $rules = [
            'receiver_id' => 'required',
            'message' => 'required_without_all:upload_file',
            'upload_file' => 'nullable|max:6000',
            'receiver_sid' => 'required|check_hash:' . $request->get('receiver_id')
        ];
        if ($request->get('shop_id') || $request->get('shop_sid')) {
            $rules['shop_id'] = 'required';
            $rules['shop_sid'] = 'required|check_hash:' . $request->get('shop_id');
        }
        $this->validate($request, $rules, [
            'message.required_without_all' => 'حداقل یکی از فیلد های پیام یا فایل باید اطلاعات داشته باشد ',
            'upload_file.max' => 'فایل انتخابی نمی تواند بیشتر از 5 مگابایت باشد '
        ]);
        $receiver = User::findOrFail($request->get('receiver_id'));
        if (inBlockList(auth()->user(), $receiver)) {
            abort(404);
        }
        if ($parentMessage = auth()->user()->hasCommunicatedBefore($receiver)) {
            $request->merge(['parent_id' => $parentMessage->id]);
        }
        $request->merge(['user_id' => auth()->id()]);
        $message = Message::create($request->all());
        event(new MessageSent($message));
        setSession([
            'header' => 'ارسال پیام',
            'message' => 'پیام شما با موفقیت ارسال گردید.',
            'type' => 'success'
        ]);
        return redirect()->back();
    }


    protected function checkIfMessageIsShowable($message)
    {
        if ($message->parent) {
            abort(404);
        }
        if ($message->user_id != auth()->id() && $message->receiver_id != auth()->id()) {
            abort(404);
        }
    }

}
