<?php

namespace App\Http\Controllers\Front\Specific;

use App\Models\Specific\FirstPageSpecialSuggestion;
use App\Models\Specific\Plan;
use App\Models\Specific\ProductDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialSuggestionController extends Controller
{
    public function index()
    {
        $firstPageSpecialSuggestions = FirstPageSpecialSuggestion::remaining();
        $selectedPlan = \request()->get('plan');
        if ($selectedPlan) {
            $firstPageSpecialSuggestions->where('plan_id', $selectedPlan);
        }
        $limit = \request()->get('limit') ?: 12;
        $data = [
            'pageTitle' => 'پیشنهادات ویژه',
            'specialSuggestions' => $firstPageSpecialSuggestions->offset(0)->limit($limit)->orderBy('created_at', 'desc')->get(),
            'hasMorePage' => $firstPageSpecialSuggestions->offset($limit)->limit($limit)->get()->count(),
            'plans' => Plan::visible()->orderBy('position')->get(),
            'selectedPlan' => $selectedPlan,
            'limit' => $limit
        ];
        return view('front.pages.specialsuggestion.index', $data);

    }
}
