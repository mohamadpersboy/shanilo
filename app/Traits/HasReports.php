<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 10/27/2018
 * Time: 3:49 PM
 */

namespace App\Traits;


use App\Models\Specific\ViolationReport;

trait HasReports
{
    public static function bootHasReport()
    {
        static::deleting(function ($object){
            $object->reports()->delete();
        });
    }
    public function reports()
    {
        return $this->morphMany(ViolationReport::class,'reportable');
    }

    public function isReportedByAuth()
    {
        return auth()->check() && $this->reports()->where('user_id',auth()->id())->exists();
    }

    public abstract function getPersianName();
}