<?php

namespace App\Http\Controllers\Front\Specific;

use App\Models\ProductMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductMessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);
        ProductMessage::query()->create([
            'description' => $request->description,
            'product_id' => $request->product_id,
            'sender_id' => auth()->user()->id,
        ]);

        return redirect()->back();
    }
}
