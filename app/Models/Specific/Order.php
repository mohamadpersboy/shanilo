<?php

namespace App\Models\Specific;

use App\Http\Helpers\Status;
use App\Models\Base\Address;
use App\Models\Base\SendType;
use App\Models\Base\User;
use App\Traits\HasReports;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, HasReports;

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable = [
        'shop_id',
        'user_id',
        'address_id',
        'send_type_id',
        'tax',
        'total',
        'show_as_customer',
        'transport_price',
        'seen',
        'status',
        'position',
        'display'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    /**:::::::::::::::**| Address |**:::::::::::::::**/
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**:::::::::::::::**| Shop |**:::::::::::::::**/
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**:::::::::::::::**| User |**:::::::::::::::**/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**:::::::::::::::**| Payment: every order must have only one payment |**:::::::::::::::**/
    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }

    /**:::::::::::::::**| Wallet transactions |**:::::::::::::::**/
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**:::::::::::::::**| Send Type |**:::::::::::::::**/
    public function sendType()
    {
        return $this->belongsTo(SendType::class);
    }

    /**:::::::::::::::**| Details |**:::::::::::::::**/
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function confirm()
    {
        \DB::transaction(function () {
            foreach ($this->details as $detail) {
                $productDetail = $detail->productDetail;
                $productDetail->count -= $detail->count;
                $productDetail->product->sell_count+=$detail->count;
                $productDetail->save();
                $productDetail->product->save();
            }
            WalletTransaction::create([
                'wallet_id' => $this->shop->wallet->id,
                'order_id' => $this->id,
                'type' => 'add',
                'source' => getUsersFullName($this->user),
                'destination' => getUsersFullName($this->shop->user),
                'price' => $this->calculateCheckoutPrice()
            ]);
        });
    }

    public function disconfirm()
    {
        \DB::transaction(function () {
            foreach ($this->details as $detail) {
                $productDetail = $detail->productDetail;
                $productDetail->count -= $detail->count;
                $productDetail->product->sell_count-=$detail->count;
                $productDetail->save();
                $productDetail->product->save();
            }
            WalletTransaction::create([
                'wallet_id' => $this->shop->wallet->id,
                'order_id' => $this->id,
                'type' => 'sub',
                'source' => getUsersFullName($this->shop->user),
                'destination' => getUsersFullName($this->user),
                'price' => $this->calculateCheckoutPrice()
            ]);
            $this->user->credit += $this->total;
            $this->user->save();
        });
    }

    public function canUpdateStatus($status)
    {
        if ($status == 0) {
            return $this->status < 3;
        }
        $statuses = $this->user_id == auth()->id() ? [3, 5] : [2, 3, 4];
        return in_array($status, $statuses) && $this->status + 1 == $status;
    }

    public function hasAddedWalletTransaction()
    {
        return $this->walletTransactions()->where('type', 'add')->exists();
    }

    public function calculateCheckoutPrice()
    {
        $transportPrice = $this->send_type_id == 1 ? $this->transport_price : 0;
        return roundPrice(subPercent($this->totalProductsPrice - $transportPrice, env('ADMIN_CHECKOUT_PERCENT'), true)) + $transportPrice;
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutator
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function getFrontStatusAttribute()
    {
        return isset(self::statuses()[$this->status]) ? self::statuses()[$this->status] : new Status('تعریف نشده', '');
    }

    public function getTotalProductsPriceAttribute()
    {
        return $this->total - $this->transport_price - $this->tax;
    }

    public static function statuses()
    {
        return [
            0 => new Status('کنسل', 'red'),
            1 => new Status('ثبت شده', 'pending'),
            2 => new Status('تایید شده', 'blue'),
            3 => new Status('تماس فروشگاه و مشتری', ''),
            4 => new Status('ارسال سفارش', 'purple'),
            5 => new Status('دریافت سفارش', 'green'),
        ];
    }

    public function getPersianName()
    {
        return [
            'name' => 'سفارش',
            'title'=>getUsersFullName($this->user),
            'url'=>route('admin.order.showAsUser',$this)
        ];
    }
}
