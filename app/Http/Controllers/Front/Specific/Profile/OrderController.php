<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Events\OrderStatusChanged;
use App\Http\Controllers\Front\Base\ProfileController;
use App\Http\Controllers\Front\Traits\Specific\HasForbiddenMessageAndView;
use App\Models\Base\User;
use App\Models\Specific\CreditLog;
use App\Models\Specific\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Base\Contact;
use App\Models\Specific\Order;
use Illuminate\Support\Collection;
use Smsir;

class OrderController extends ProfileController
{
    use HasForbiddenMessageAndView;

    const VIEW_ROOT = 'front.pages.profile.order.';
    protected $data;
    protected $type;
    /**
     * @var Collection
     */
    protected $orders;
    /**
     * @var User
     */
    protected $user;


    public function __construct()
    {
        $this->middleware(['check.order.status'])->only(['updateStatus']);
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Orders
    # Handles order operations in front user profile
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function index($type)
    {
        $func = camel_case($type . ' orders');
        if (method_exists($this, $func)) {
            $this->user = auth()->user();
            $this->type = $type;
            return $this->$func();
        }
        abort(404);
    }

    public function show(Order $order)
    {
        $this->checkIfOrderBelongsToUser($order);
        $this->user = auth()->user();
        $this->type = $order->user_id == auth()->id() ? 'self' : 'others';
        if ($order->user_id != auth()->id()) {
            $order->update(['seen' => 1]);
        }
        $this->setIndexData();
        unset($this->data['orders']);
        $this->data['order'] = $order->load('details', 'user', 'shop');

        return $this->view('show');
    }

    public function updateStatus(Order $order, Request $request)
    {

        $this->checkIfOrderBelongsToUser($order);
        $this->validate($request, [
            'status' => 'required'
        ], [], [
            'status.required' => 'اطلاعات ارسال شده نامعتبر است.'
        ]);

        $status = $request->get('status');
        if (!$order->canUpdateStatus($status)) {
            return response()->json(['errors' => ['message' => ['شما مجاز به انجام این عمل نمی باشید.']]], 422);
        }
        setSession([
            'header' => 'تغییر وضعیت سفارش',
            'message' => 'وضعیت سفارش با موفقیت ویرایش گردید.',
            'type' => 'success'
        ]);
        \DB::transaction(function () use ($order, $status) {
            if ($status == 0 && auth()->user()->id == $order->user_id) {
                CreditLog::query()->create([
                    'price' => $order->total,
                    'status' => CreditLog::increaseStatus,
                    'type' => CreditLog::customerCancelType,
                    'user_id' => auth()->user()->id
                ]);
            } else {
                CreditLog::query()->create([
                    'price' => $order->total,
                    'status' => CreditLog::increaseStatus,
                    'type' => CreditLog::shopCancelType,
                    'user_id' => $order->user_id
                ]);
            }
            $order->update(['status' => $status]);
            event(new OrderStatusChanged($order));
            $this->sendMobileConfirmationSMS($order->user->mobile);
        });

        if ($request->ajax()) {
            return [
                'url' => back()->getTargetUrl()
            ];
        }
        return back();

    }

    protected function othersOrders()
    {
        $orders = Order::query();
        if ($shopId = \request()->get('shop_id')) {
            $orders->where('shop_id', $shopId)->whereIn('shop_id', $this->user->shops()->pluck('id')->toArray());
        } else {
            $orders->whereIn('shop_id', $this->user->shops()->pluck('id')->toArray());
        }
        $this->filter($orders);
        $this->orders = $orders->latest()->paginate(PROFILE_PAGINATION_COUNT);
        $this->setIndexData();
        return $this->view('index');
    }

    protected function selfOrders()
    {

        $orders = Order::query();
        if ($shopId = \request()->get('shop_id')) {
            $orders->where('user_id', auth()->id())->where('shop_id', $shopId);
        } else {
            $orders->where('user_id', auth()->id());
        }
        $this->filter($orders);
        $this->orders = $orders->latest()->paginate(PROFILE_PAGINATION_COUNT);
        $this->setIndexData();
        return $this->view('index');
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected function setIndexData()
    {
        $this->data = [
            'user' => $this->user,
            'activeMenu' => 'orders',
            'subActiveMenu' => $this->type,
            'type' => $this->type,
            'pageTitle' => $this->type == 'self' ? 'سفارشات من' : 'سفارشات فروشگاههای من',
            'orders' => $this->orders,
            'shops' => $this->type == 'self' ? Shop::whereHas('orders', function (Builder $builder) {
                $builder->where('user_id', auth()->id());
            })->get() : $this->user->shops,
            'selectedShop' => \request()->get('shop_id'),
            'selectedId' => \request()->get('id'),
            'selectedTrackingCode' => \request()->get('tracking_code')
        ];
    }

    /**
     * @param Order $order
     */
    protected function checkIfOrderBelongsToUser(Order $order)
    {
        if ($order->user_id != auth()->id() && $order->shop->user_id != auth()->id()) {
            abort(404);
        }
    }

    /**
     * @param $orders
     */
    protected function filter($orders)
    {
        if ($id = \request()->get('id')) {
            $orders->where('id', 'like', "%{$id}%");
        }
        if ($trackingCode = \request()->get('tracking_code')) {
            $orders->whereHas('payment', function (Builder $builder) use ($trackingCode) {
                $builder->where('tracking_code', $trackingCode);
            });
        }
    }


    // SMS
    public function sendMobileConfirmationSMS($mobile)
    {
        $message = 'تغییر وضعیت مربوط به خرید' . PHP_EOL;
        $message .= 'کاربر گرامی وضعیت خرید شما تغییر پیدا کرد برای مشاهده به پنل کاربری خود مراجعه فرمائید.' . PHP_EOL;
        $message .= 'shanilo.com';
        // $message=str_replace('%code%',$code,$message);
        //Smsir::send([$message],[$mobile]);
    }


}
