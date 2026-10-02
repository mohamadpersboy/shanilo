<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Controllers\Controller;
use App\Models\Msg;
use Illuminate\Http\Request;

class MsgController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
            'receiver_id' => 'nullable|exists:users,id',
            'shop_id' => 'nullable|exists:shops,id',
        ]);

        \DB::beginTransaction();

        $msg = Msg::query()->create([
            'subject' => $request->subject,
            'sender_id' => auth()->user()->id,
            'status' => Msg::STATUS_SEND,
            'receiver_id' => $request->get('receiver_id', 0),
            'shop_id' => $request->get('shop_id', 0),
            'is_show' => '1',
        ]);

        $detail = $msg->details()->create([
            'description' => $request->description,
            'creator_id' => auth()->user()->id,
        ]);

        if ($request->hasFile('upload')) {
            $detail->update(['file' => $request->file('upload')->store('msg', 'public')]);
        }

        \DB::commit();

        return response()->json([
            'header' => 'ارسال پیام',
            'message' => 'پیام شما با موفقیت ارسال گردید.',
            'type' => 'success',
        ]);
    }

    private function getMsg($request)
    {
        $message = Msg::query()
            ->with(['details', 'sender', 'receiver', 'shop'])
            ->latest();

        if ($request->filled('msg_code')) {
            $message = $message->where('id', '=', $request->msg_code);
        }

        if ($request->filled('msg_status')) {
            $message = $message->where('status', '=', $request->msg_status);
        }
        return $message;
    }

    public function msgShop(Request $request)
    {
        $shopids = auth()->user()->shops()->get()->pluck('id')->toArray();

        $msgs = $this->getMsg($request)
            ->whereIn('shop_id', $shopids)
            ->paginate(20);

        return response()->json([
            'status' => '200',
            'html' => view('front.pages.profile.msg.shop_msg', compact('msgs'))->render(),
        ]);
    }

    public function myMsg(Request $request)
    {
        $msgs = $this->getMsg($request)
            ->where('shop_id', '=', 0)
            ->where('is_ticket', '=', 0)
            ->whereRaw("(receiver_id = ? or sender_id = ?)", [auth()->user()->id, auth()->user()->id])
            ->paginate(20);

        return response()->json([
            'status' => 200,
            'html' => view('front.pages.profile.msg.my_msg', compact('msgs'))->render(),
        ]);
    }

    public function show($id)
    {
        $msg = Msg::query()->with(['details.creator', 'sender', 'receiver'])->findOrFail($id);
        $user = auth()->user();

        if ($msg->receiver_id && $msg->receiver->is($user)) {
            $msg->update(['is_show' => $msg->details()->latest()->first()->creator->is($user) ? '1' : '0']);
        }

        $activeMenu = 'messages';
        return view('front.pages.profile.message.show', compact('msg', 'user', 'activeMenu'));
    }

    public function ticket(Request $request)
    {
        $msgs = $this->getMsg($request)
            ->where('is_ticket', '=', 1)
            ->whereRaw("(receiver_id = ? or sender_id = ?)", [auth()->user()->id, auth()->user()->id])
            ->paginate(20);

        return response()->json([
            'status' => 200,
            'html' => view('front.pages.profile.msg.ticket_msg', compact('msgs'))->render(),
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['description' => 'required']);
        \DB::beginTransaction();
        $msg = Msg::query()->findOrFail($id);

        $msg->update([
            'status' => $msg->details()->latest()->first()->creator->is(auth()->user()) ? Msg::STATUS_SEND : Msg::STATUS_REPLY,
            'is_show' => '1',
        ]);

        if ($msg->sender_id == auth()->user()->id || $msg->receiver_id == auth()->user()->id) {
            $detail = $msg->details()->create([
                'description' => $request->description,
                'creator_id' => auth()->user()->id,
            ]);
            if ($request->hasFile('upload')) {
                $detail->update(['file' => $request->file('upload')->store('msg', 'public')]);
            }
            \DB::commit();
            return redirect()->back()->with('msg', 'با موفقیت ثبت شد .');
        }

        return abort(404);
    }

    public function sendTicketForm()
    {
        return response()->json([
            'data' => view('front.pages.profile.msg.ticket')->render(),
            'status' => 200,
        ]);
    }

    public function sendTicket(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
        ]);

        \DB::beginTransaction();
        $msg = Msg::query()->create([
            'subject' => $request->subject,
            'sender_id' => auth()->user()->id,
            'status' => Msg::STATUS_SEND,
            'is_ticket' => 1,
        ]);
        $detail = $msg->details()->create([
            'description' => $request->description,
            'creator_id' => auth()->user()->id,
        ]);

        if ($request->hasFile('upload')) {
            $detail->update(['file' => $request->file('upload')->store('msg', 'public')]);
        }
        \DB::commit();

        return response()->json([
            'status' => 200,
            'msg' => 'تیکت با موفقیت ارسال شد ',
        ]);
    }
}
