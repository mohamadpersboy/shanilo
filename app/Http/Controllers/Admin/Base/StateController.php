<?php

namespace App\Http\Controllers\Admin\Base;

use App\Models\Base\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function getChildren(State $state)
    {
        return $state->cities()->orderBy('name')->get(['id as value','name as title']);
    }
}
