<?php
function mainSetting($key)
{
    $result = '';
    // get object from DB
    $object = \App\Models\Base\Setting::where('name', $key)->firstOrFail()->toArray();
    switch ($object['type']) {
        case ('string'):
            $result = $object['value'];
            break;
        case ('text'):
            $result = $object['value'];
            break;
        case ('file'):
            $result = 'Hanoz Ok nashode ast';
            break;
        case ('bool'):
            $result = ($object['value'] == '1') ? true : false;
            break;
    }
    return $result;

}









