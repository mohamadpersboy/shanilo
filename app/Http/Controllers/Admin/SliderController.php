<?php

namespace App\Http\Controllers\Admin;

use App\Grid\Admin\SliderGrid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use SrkGrid\GridView\Grid;

class SliderController extends Controller
{
    public function create()
    {
        $sliders = DB::table('home_sliders')->whereNull('deleted_at');

        $grid = Grid::make(SliderGrid::class, $sliders);

        return view('admin.slider', compact('sliders', 'grid'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $path = ($request->file('image')->store('slider', 'public'));

        if ($request->type == 'min_image') {
            DB::table('home_sliders')->where('type', '=', 'min_image')->delete();
        }
        DB::table('home_sliders')->insert([
                'path'=>$path,
                'type'=>$request->type,
                'link'=>$request->link
            ]);
        
        DB::commit();
        return redirect()->back();
    }

    public function delete($id)
    {
        DB::table('home_sliders')->whereId($id)->delete();
    }
}
