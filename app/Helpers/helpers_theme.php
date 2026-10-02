<?php
function genderStatus($gender)
{
    $result = '';
    switch ($gender) {
        case 'male';
            $result = "مرد";
            break;
        case 'female';
            $result = "زن";
            break;
        case 'boy';
            $result = "پسر";
            break;
        case 'girl';
            $result = "دختر";
            break;
        case 'baby';
            $result = "کودک";
            break;
    }
    return $result;
}

function militaryStatus($military)
{
    $result = '';
    switch ($military) {
        case 'exempt';
            $result = 'معافیت';
            break;
        case 'end';
            $result = 'پایان خدمت';
            break;
        case 'inductee';
            $result = 'مشمول';
            break;
        case 'etc';
            $result = 'غیره';
            break;

    }
    return $result;

}

function displayStatus($display)
{
    $result = '';
    switch ($display) {
        case '1';
            $result = "<span class='label label-success'>بله</span>";
            break;
        case '0';
            $result = "<span class='label label-danger'>خیر</span>";
            break;
    }
    return $result;

}

function seenStatus($seenStatus)
{
    $result = '';
    switch ($seenStatus) {
        case '1';
            $result = "<span class='label label-success'>دیده شده</span>";
            break;
        case '0';
            $result = "<span class='label label-danger'>دیده نشده</span>";
            break;
    }
    return $result;
}