<?php

namespace App\Http\Controllers\Admin;

use App\Grid\Admin\SocialNetworkGrid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SocialNetwork;
use SrkGrid\GridView\Grid;

class SocialNetworkController extends Controller
{
    public function index()
    {
        $grid = Grid::make(SocialNetworkGrid::class, SocialNetwork::query());

        return view('admin.social_network.index', compact('grid'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link'=>'required',
            'title'=>'required'
        ]);
        $icon = null;
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon')->store('social_network', 'public');
        }
        SocialNetwork::query()->create([
            'link'=>$request->link,
            'title'=>$request->title,
            'follower'=>$request->follower,
            'icon'=>$icon
        ]);
        return redirect()->back();
    }

    public function delete($id)
    {
        SocialNetwork::query()->find($id)->delete();
    }
}
