<?php

namespace App\Models;

use App\Models\ModelTrait\Mutator\RequestCheckoutCreditMutator;
use App\Models\ModelTrait\Relation\RequestCheckoutCreditRelation;
use App\Models\Specific\CreditLog;
use Illuminate\Database\Eloquent\Model;

class RequestCheckoutCredit extends Model
{
    use RequestCheckoutCreditMutator, RequestCheckoutCreditRelation;

    public $timestamps = false;
    /**
     * table name
     *
     * @var string
     */
    protected $table = "requests_checkout_credit";

    /**
     * White list for store and update
     *
     * @var array
     */
    protected $fillable = ['user_id', 'price', 'tracking_code', 'request_at', 'done_at', 'status', 'bank_cart_id'];

    protected $appends = ['status_request'];

    /**
     * Observe for RequestCheckoutCredit
     */
    public static function boot()
    {
        parent::boot();

        self::created(function ($request) {
            $request->update(['request_at' => now()]);
        });

        self::updated(function ($request) {

            if ($request->isDirty('status') && $request->status == 'done') {

                $price = (int)str_replace(',', '', $request->price);

                $newPrice = ($request->user->credit - $price);

                $request->user()->update(['credit' => $newPrice]);

                CreditLog::query()->create([
                    'price' => $price,
                    'status' => CreditLog::decreaseStatus,
                    'type' => CreditLog::requestCheckoutType,
                    'user_id' => $request->user_id
                ]);

            }

        });
    }
}
