<?php

namespace App\Traits;
use Spatie\Activitylog\Traits\LogsActivity;

trait AtlasLogActivityTrait
{
    use LogsActivity;
    public static function getName()
    {
        return  __(self::LOG_ACTIVITY_KEY);
    }
}