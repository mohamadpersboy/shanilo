<?php

namespace App\Http\Controllers\Front\Specific\Profile;


use App\Events\UserSuggestedAProduct;
use App\Models\Base\User;
use App\Models\Specific\ProductDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShareController extends Controller
{
    public function friendsToShare()
    {
        $key = str_replace('@','',\request()->get('key'));
        $blockers = auth()->user()->blockers()->pluck('id')->toArray();
        $users = User::whereNotIn('id', $blockers)->whereNotIn('role_id',[1,2])->where(function (Builder $builder) use ($key) {
            $builder->where('email', 'like', "%{$key}%")
                ->orWhere('uid', 'like', "%{$key}%")
                ->orWhere('name', 'like', "%{$key}%")
                ->orWhere('family', 'like', "%{$key}%");
        })->get();
        return [
            'view' => \View::make('front.partial.items.share-friends', compact('users'))->render()
        ];
    }

    public function shareWithFriends(Request $request)
    {
        $this->validator($request);
        $users=User::find(explode(',',$request->get('users')));
        if($users->count()){
                $productDetailId=$request->get('product_detail_id');
                foreach ($users as $user){
                    if($user->hasUserSuggestion($productDetailId))
                        continue;
                    $user->userSuggestions()->create([
                        'offerer_id'=>auth()->id(),
                        'product_detail_id'=>$productDetailId
                    ]);
                }
                event(new UserSuggestedAProduct($users,ProductDetail::find($productDetailId)));
                return [
                    'header'=>'ارسال محصول به دوستان',
                    'message'=>'محصول با موفقیت به دوستان ارسال گردید.',
                    'type'=>'success'
                ];
        }
        return response()->json(['errors'=>['message'=>['اطلاعات ارسال شده نامعتبر است.']]],422);
    }

    /**
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $this->validate($request, [
            'users' => 'required',
            'product_detail_id' => 'required|exists:product_details,id',
            'product_detail_sid' => 'required|check_hash:' . $request->get('product_detail_id')
        ], [
            'users.required' => 'هیچ کاربری انتخاب نشده است.',
            'product_detail_id.required' => 'اطلاعات ارسال شده نامعتبر است.',
            'product_detail_id.exists' => 'اطلاعات ارسال شده نامعتبر است.',
            'product_detail_sid.required' => 'اطلاعات ارسال شده نامعتبر است.',
            'product_detail_sid.check_hash' => 'اطلاعات ارسال شده نامعتبر است.',
        ]);
    }
}
