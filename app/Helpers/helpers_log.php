<?php
function showLogActivity($log){
    $result = '';
    switch ($log) {
        case 'created';
            $result = "ایجاد";
            break;
        case 'updated';
            $result = "ویرایش";
            break;
        case 'deleted';
            $result = "حذف";
            break;
    }
    return $result;
}

function showLogModel($model){
    $result = '';
    switch ($model) {
        case 'App\Models\Advertisement\AdPlan';
            $result = "پلن تبلیغات";
            break;
        case 'App\Models\Advertisement\AdTime';
            $result = "زمان تبلیغات";
            break;
        case 'App\Models\Advertisement\AdDetail';
            $result = "جزئیات تبلیغات";
            break;
        case 'App\Models\Advertisement\AdSection';
            $result = "مکان تبلیغات";
            break;
        case 'App\Models\Advertisement\Advertisement';
            $result = "تبلیغات";
            break;
        case 'App\Models\Base\Ticket';
            $result = "تیکت";
            break;
    }
    return $result;
}
