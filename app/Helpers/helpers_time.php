<?php
function timeConvertToPersian($time)
{
    $date = [];
    $date['date'] = \Morilog\Jalali\jDateTime::strftime('%d  %B  %Y', strtotime($time));
//    $date['dateAndTime'] = \Morilog\Jalali\jDateTime::strftime('%m : %H - %d  %B  %Y', strtotime($time));
    $date['dateAndTime'] = \Morilog\Jalali\jDateTime::strftime('%m:%H - %Y/%m/%d', strtotime($time));
    $date['month'] = \Morilog\Jalali\jDateTime::strftime('%B', strtotime($time));
    $date['day'] = \Morilog\Jalali\jDateTime::strftime('%d', strtotime($time));
    $date['year'] = \Morilog\Jalali\jDateTime::strftime('%Y', strtotime($time));
    $date['time'] = \Morilog\Jalali\jDateTime::strftime('%H : %m', strtotime($time));
    return $date;
}

function showPersianFullTime($time)
{
    switch (__('content.direction')) {
        case 'rtl';
            $result = \Morilog\Jalali\jDate::forge($time)->format('H:i') ." ". \Morilog\Jalali\jDate::forge($time)->format('Y/m/d');
            break;
        case 'ltr';
            $result = \Carbon\Carbon::parse($time)->format('Y-m-d') ." ". \Carbon\Carbon::parse($time)->format('H:i');
            break;
    }
    return $result;
}

function ShowDate($time)
{
    switch (__('content.direction')) {
        case 'rtl';
            $result = \Morilog\Jalali\jDate::forge($time)->format('Y/m/d');
            break;
        case 'ltr';
            $result = \Carbon\Carbon::parse($time)->format('Y-m-d');
            break;
    }
    return $result;
}

function ShowDateForChart($time)
{
    switch (__('content.direction')) {
        case 'rtl';
            $result = \Morilog\Jalali\jDate::forge($time)->format('Y-m-d');
            break;
        case 'ltr';
            $result = \Carbon\Carbon::parse($time)->format('Y-m-d');
            break;
    }
    return $result;
}

function ShowDateForFlotChart($time)
{
    switch (__('content.direction')) {
        case 'rtl';
            $result = \Morilog\Jalali\jDate::forge($time)->format('m/d');
            break;
        case 'ltr';
            $result = \Carbon\Carbon::parse($time)->format('m/d');
            break;
    }
    return $result;
}

function ShowTime($time)
{
    switch (__('content.direction')) {
        case 'rtl';
            $result = \Morilog\Jalali\jDate::forge($time)->format('H:i');
            break;
        case 'ltr';
            $result = \Carbon\Carbon::parse($time)->format('H:i');
            break;
    }
    return $result;
}

function NowDay()
{
    switch (__('content.direction')) {
        case 'rtl';
            $result = \Morilog\Jalali\jDate::forge()->format('%A');
            break;
        case 'ltr';
            $result = \Carbon\Carbon::now()->formatLocalized('%A');
            break;
    }
    return $result;
}

function NowDate()
{
    switch (__('content.direction')) {
        case 'rtl';
            $result = \Morilog\Jalali\jDate::forge()->format('%d/%B/%Y');
            break;
        case 'ltr';
            $result = \Carbon\Carbon::now()->formatLocalized('%d/%B/%Y');
            break;
    }
    return $result;
}

//مثلا مقدار 00:15:25 بگیره و به این تبدیل کند 15 دقیقه و 25 ثانیه
function convert_time_to_string($time){
    $array = array();$convert_time="";
    $array = explode(":",$time);
    if($array[0] == "00") {
        if($array[1] > "00"){$convert_time .= (int)$array[1]." "."دقیقه و"." ";}
        if ($array[2] > "00") {$convert_time .= (int)$array[2] . " " . "ثانیه" . " ";}
    } else{
        if($array[0] > "00"){$convert_time .= (int)$array[0]." "."ساعت و"." ";}
        if($array[1] > "00"){$convert_time .= (int)$array[1]." "."دقیقه"." ";}
    }
    return $convert_time;
}

function show_persian_with_month($time){
    return $result = \Morilog\Jalali\jDate::forge($time)->format('d / %B / Y');
}

function show_persian_with_month_no_slash($time){
    return $result = \Morilog\Jalali\jDate::forge($time)->format('d %B Y');
}

function show_persian_day_string($time){
    return $result = \Morilog\Jalali\jDate::forge($time)->format('%A');
}

function show_persian_with_explode_array($time){
    $date_explode['year'] = \Morilog\Jalali\jDate::forge($time)->format('Y');
    $date_explode['month'] = \Morilog\Jalali\jDate::forge($time)->format('%B');
    $date_explode['day'] = \Morilog\Jalali\jDate::forge($time)->format('d');
    return $date_explode;
}

function showAgoTime($time){
    return \Morilog\Jalali\jDate::forge($time)->ago();
}

function makeExpireTime($day,$from=null)
{
    if($from){
        $dt = \Carbon\Carbon::parse($from);
    } else {
        $dt = \Carbon\Carbon::now();
    }
    return $dt->addDays($day); 
}

function showExpireStatus($timestamp)
{
    $nowTime = time();
    if ($timestamp > $nowTime) {
        $res = "<span style='font-size: 10px' class='text-success'>فعال</span>";
    } else {
        $res = "<span  style='font-size: 10px' class='text-danger'>منقضی شده</span>";
    }
    return $res;
}