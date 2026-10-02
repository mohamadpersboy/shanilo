<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Models\Msg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MsgController extends Controller
{
    public function index()
    {
        Msg::query()->where('is_ticket',1);
        
        return view('admin.ticket.index');
    }
}
