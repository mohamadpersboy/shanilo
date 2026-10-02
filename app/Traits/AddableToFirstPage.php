<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 11/26/2018
 * Time: 2:19 PM
 */

namespace App\Traits;


use App\Models\Specific\FirstPageSpecialSuggestion;
use App\Models\Specific\Plan;
use App\Models\Specific\SpecialSuggestion;
use Carbon\Carbon;

trait AddableToFirstPage
{

    /**
     * @param Plan $plan
     * @param array $paymentData
     * @return FirstPageSpecialSuggestion
     */
    public function addToFirstPage(Plan $plan, $paymentData = [])
    {
        $relationName = $this instanceof SpecialSuggestion ? 'firstPageSpecialSuggestion' : 'firstPageSpecialSell';
        $function = 'add' . $plan->func;
        $expiresAt = Carbon::now()->$function($plan->amount);
        $object = $this->$relationName()->create([
            'plan_id' => $plan->id,
            'expires_at' => $expiresAt
        ]);
        if(is_array($paymentData)){
            $paymentData = array_merge([
                'pay_type_id' => request()->get('pay_type_id'),
                'price' => $plan->price,
                'status' => 'successful'
            ], $paymentData);
            $object->payment()->create($paymentData);
        }
        return $object;
    }
}