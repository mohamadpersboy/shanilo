<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\Week;

class WeekController extends Controller
{
    public function index()
    {
        $items = array(
            array("title" => 'مدیریت ساعت کار هفته',"link" => route('admin.week.index'))
        );

        $data['weeks'] = [
            ['shamsi' => 'شنبه','milady' => 'sat'],
            ['shamsi' => 'یکشنبه','milady' => 'sun'],
            ['shamsi' => 'دوشنبه','milady' => 'mon'],
            ['shamsi' => 'سه شنبه','milady' => 'tue'],
            ['shamsi' => 'چهار شنبه','milady' => 'wed'],
            ['shamsi' => 'پنج شنبه','milady' => 'thu'],
            ['shamsi' => 'جمعه','milady' => 'fri'],
        ];

        $data['times'] = [
            ['show' => '01:00','value' => '1'],
            ['show' => '02:00','value' => '2'],
            ['show' => '03:00','value' => '3'],
            ['show' => '04:00','value' => '4'],
            ['show' => '05:00','value' => '5'],
            ['show' => '06:00','value' => '6'],
            ['show' => '07:00','value' => '7'],
            ['show' => '08:00','value' => '8'],
            ['show' => '09:00','value' => '9'],
            ['show' => '10:00','value' => '10'],
            ['show' => '11:00','value' => '11'],
            ['show' => '12:00','value' => '12'],
            ['show' => '13:00','value' => '13'],
            ['show' => '14:00','value' => '14'],
            ['show' => '15:00','value' => '15'],
            ['show' => '16:00','value' => '16'],
            ['show' => '17:00','value' => '17'],
            ['show' => '18:00','value' => '18'],
            ['show' => '19:00','value' => '19'],
            ['show' => '20:00','value' => '20'],
            ['show' => '21:00','value' => '21'],
            ['show' => '22:00','value' => '22'],
            ['show' => '23:00','value' => '23'],
            ['show' => '24:00','value' => '24'],
        ];

        $data['queryWeeks'] = Week::all()->toArray();
        return view('admin.pages.week.index', compact('items','data'));
    }

    public function store(Request $request)
    {
        $weeks = $request->get('week');
        $froms = $request->get('from');
        $tos = $request->get('to');
        $i = 0;
        foreach ($weeks as $week) {
            $checkWeek = Week::where('week', $week)->get();
            if($checkWeek->count()){
                $checkWeek->first()->update([
                    'from' => $froms[$i],
                    'to' => $tos[$i],
                ]);
            } else {
                Week::create([
                    'week' => $weeks[$i],
                    'from' => $froms[$i],
                    'to' => $tos[$i],
                ]);
            }
            $i++;
        }
        return redirect()->back()->with('msg','تغییرات با موفقیت انجام شد.');
    }
}
