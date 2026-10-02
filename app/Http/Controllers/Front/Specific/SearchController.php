<?php

namespace App\Http\Controllers\Front\Specific;

use App\Models\Base\User;
use App\Models\Specific\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $key = str_replace('@', '', $request->get('key'));
        $users = User::whereNotIn('role_id',[1,2])->where(function (Builder $builder) use ($key) {
            $builder->where('name', 'like', "%{$key}%")
                ->orWhere('family', 'like', "%{$key}%")
                ->orWhere('uid', 'like', "%{$key}%");
        })->get();
      //  dd($users);

        $shops = Shop::where('title', 'like', "%{$key}%")
            ->orWhere('uid', 'like', "%{$key}%")->get();

        $items = $users->merge($shops);
        return [
            'view' => \View::make('front.partial.ajax.search-result', compact('items'))->render()
        ];
    }
}
