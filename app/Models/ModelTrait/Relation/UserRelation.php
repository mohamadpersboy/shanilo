<?php

namespace App\Models\ModelTrait\Relation;


use App\Models\RequestCheckoutCredit;

trait UserRelation
{
    /**
     * relation by RequestCheckoutCredit class
     *
     * @return mixed
     */
    public function requestCheckoutCredit()
    {
        return $this->hasMany(RequestCheckoutCredit::class)->where('status','pending');
    }
}
