<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\Calendar;

use Morilog\Jalali\jDateTime;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $items = array(
            array("title" => __('content.management_calendar'),"link" => route('admin.calendar.index'))
        );
        
        $now = Carbon::now();
        $data['jalali'] = jDateTime::toJalali($now->year, $now->month, $now->day);

        $data['calendars'] = Calendar::all()->toArray();
        $data['calendar'] = array_column(Calendar::all()->toArray(),'date');

        $allowed_year = [$data['jalali'][0], $data['jalali'][0]+1];
        $allowed_month = [1,2,3,4,5,6,7,8,9,10,11,12];
        if(isset($_GET['year']) && isset($_GET['month']) && in_array($_GET['year'], $allowed_year) && in_array($_GET['month'], $allowed_month)){
            $Gregorian = jDateTime::toGregorian($_GET['year'], $_GET['month'], 1);
            $data['jalali'][0] = $_GET['year'];
            $data['jalali'][1] = $_GET['month'];
        } else {
            $Gregorian = jDateTime::toGregorian($data['jalali'][0], $data['jalali'][1], 1);
        }
        $dt = Carbon::createFromDate($Gregorian[0], $Gregorian[1], $Gregorian[2]);
        $day = $Gregorian[2];
        if($data['jalali'][1] == 12){
            $month_days = 29;
        } elseif($data['jalali'][1] <= 6){
            $month_days = 31;
        } else {
            $month_days = 30;
        }
        $last_day = $Gregorian[2]+$month_days;
        return view('admin.pages.calendar.index', compact('items','data','Gregorian ','dt','day','last_day'));
    }

    public function store(Request $request)
    {
        $date = $request->get('date');
        $morning = $request->get('morning');
        $noon = $request->get('noon');
        $afternoon = $request->get('afternoon');
        if(Calendar::where('date',$date)->get()->count()){
            Calendar::where('date',$date)->update([
                'morning' => $morning,
                'noon' => $noon,
                'afternoon' => $afternoon,
            ]);
        } else {
            Calendar::create([
                'date' => $date,
                'morning' => $morning,
                'noon' => $noon,
                'afternoon' => $afternoon,
            ]);
        }
    }
}
