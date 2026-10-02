<?php

namespace App\Providers;

use App\Models\Base\Category;
use App\Models\Base\Ticket;
use App\Models\Specific\Announcement;
use App\Models\Specific\AnnouncementCategory;
use App\Models\Specific\ArticleCategory;
use App\Models\Specific\Artist;
use App\Models\Base\Contact;
use App\Models\Specific\Cart;
use App\Models\Specific\Comparison;
use App\Models\Specific\Favorite;
use App\Models\Specific\MainCategory;
use App\Models\Specific\Message;
use App\Models\Specific\MusicArchive;
use App\Models\Specific\Order;
use App\Models\Specific\Product;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\ProductInquiry;
use App\Models\Specific\VideoCategory;
use App\Models\Specific\ViolationReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('fa');
        Validator::extend('check_hash', function ($attribute, $value, $parameters, $validator) {
            if (isset($parameters[1]) && $parameters[1] == true) {
                return Hash::check($value, $parameters[0]);
            } else {
                return Hash::check($parameters[0], $value);
            }
        });
        Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/(\+98|0)?9\d{9}/', $value) && strlen($value)==11;
        });
        Validator::extend('iban', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[a-zA-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16}/', $value);
        });
        Validator::extend('national_code', function ($attribute, $value, $parameters, $validator) {
            if (!preg_match('/^[0-9]{10}$/', $value))
                return false;
            for ($i = 0; $i < 10; $i++)
                if (preg_match('/^' . $i . '{10}$/', $value))
                    return false;
            for ($i = 0, $sum = 0; $i < 9; $i++)
                $sum += ((10 - $i) * intval(substr($value, $i, 1)));
            $ret = $sum % 11;
            $parity = intval(substr($value, 9, 1));
            if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
                return true;
            return false;
        });
        Validator::extend('farsi_date', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])$/', $value);
        });
        Validator::extend('exist_hashed', function ($attribute, $value, $parameters, $validator) {
            $value = md5($value);
            $column = $parameters[1];
            return !!\DB::table($parameters[0])->where($column, $value)->first();

        });
        \Schema::defaultStringLength(191);

        view()->composer(['admin.partial.sidebar'], function ($view) {
            $data_header['contacts'] = \App\Models\Base\ContactUs::where('read', 1)->get();

            $data_header['messages']=Message::where('receiver_id',null)->unRead()->count();

            $data_header['adrequests'] = \App\Models\Advertisement\AdRequest::where('status', 1)->get();

            $data_header['comments'] = \App\Models\Base\Comment::pending()->count();
            $data_header['violationreports']=ViolationReport::notSeen()->count();
       /*     $data_header['orders'] = Order::where('seen', 0)->count();*/


            //  $data_header['factors'] = \App\Models\Base\Payment::whereHas('factor', function ($query) { $query->where('visited', 1); })->where('pay_subject',1)->get();
            $view->with(compact('data_header'));


        });

        view()->composer('front.partial.header', function ($view) {

        });
        view()->composer('front.partial.dashboard', function ($view) {
            $newMessages = Message::where('receiver_id', auth()->id())->unRead()->count();
            $newOrders = Order::whereHas('shop', function (Builder $builder) {
                $builder->where('user_id', auth()->id());
            })->where('seen', 0)->count();
            $view->with(['newMessages' => $newMessages, 'newOrders' => $newOrders]);
        });
        view()->composer('front.partial.parts.order-header', function ($view) {
            $selfOrdersCount = Order::where('user_id', auth()->id())->count();
            $othersOrdersCount = Order::whereIn('shop_id', auth()->user()->shops()->pluck('id')->toArray())->count();
            $view->with(['selfOrdersCount' => $selfOrdersCount, 'othersOrdersCount' => $othersOrdersCount]);
        });
        view()->composer('front.partial.footer', function ($view) {

        });
        View::composer(['errors::404'], function ($view) {
            $items = [];
            $view->with(compact('items'));
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
