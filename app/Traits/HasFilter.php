<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 11/12/2018
 * Time: 10:15 AM
 */

namespace App\Traits;


use App\Models\Specific\ProductDetail;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{

    public function scopeFilter(Builder $builder)
    {
        foreach ($this->filters as $filter) {
            $method = camel_case("filter by $filter");
            if (request()->get($filter) && method_exists($this, $method)) {
                $this->$method($builder, request()->get($filter));
            }
        }
        return $builder;
    }
}
