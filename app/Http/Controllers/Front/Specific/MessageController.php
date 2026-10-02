<?php

namespace App\Http\Controllers\Front\Specific;

use App\Models\Base\User;
use App\Models\Specific\Message;
use App\Models\Specific\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function create($type, $id)
    {
        return [
            'view' => \View::make('front.partial.ajax.send-message-form', $this->setData($type, $id))->render()
        ];
    }

    public function store(Request $request)
    {
        $rules = [
            'subject' => 'required',
            'receiver_id' => 'required',
            'message' => 'required',
            'receiver_sid' => 'required|check_hash:' . $request->get('receiver_id')
        ];
        if ($request->get('shop_id') || $request->get('shop_sid')) {
            $rules['shop_id'] = 'required';
            $rules['shop_sid'] = 'required|check_hash:' . $request->get('shop_id');
        }
        $this->validate($request, $rules, [
            'message' => 'پیام'
        ]);
        $receiver = User::findOrFail($request->get('receiver_id'));
        if (inBlockList(auth()->user(), $receiver)) {
            abort(404);
        }
//        if ($parentMessage = auth()->user()->hasCommunicatedBefore($receiver)) {
//            $request->merge(['parent_id' => $parentMessage->id]);
//        }
        $request->merge(['user_id' => auth()->id()]);
        $msg = Message::create($request->all());

        if ($request->hasFile('file')) {
            $uploadPath = $request->file('file')->store('message', 'public');

            Message::query()->where('id', '=', $msg->id)->update(['upload_file' => $uploadPath]);
        }
        return [
            'header' => 'ارسال پیام',
            'message' => 'پیام شما با موفقیت ارسال گردید.',
            'type' => 'success'
        ];
    }

    /**
     * @param $type
     * @param $id
     * @return array
     */
    protected function setData($type, $id)
    {
        if ($type == 'user') {
            return [
                'receiver' => User::findOrFail($id),
                'shop' => null
            ];

        } else {
            return [
                'shop' => Shop::findOrFail($id),
                'receiver' => Shop::findOrFail($id)->user
            ];
        }
    }
}
