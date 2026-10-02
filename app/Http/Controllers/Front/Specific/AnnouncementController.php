<?php

namespace App\Http\Controllers\Front\Specific;

use App\Models\Base\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    //public function seen(Announcement $announcement)
    public function seen($announcement)
    {
        $result = Announcement::find($announcement)->update(['seen'=>true]);
        if($result){
            return [
                'true'
            ];    
        }
        return [
            'false'
        ];
    }
}
