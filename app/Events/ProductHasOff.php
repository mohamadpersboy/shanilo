<?php

namespace App\Events;

use App\Models\Specific\ProductDetail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductHasOff
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var ProductDetail
     */
    public $productDetail;

    /**
     * Create a new event instance.
     *
     * @param ProductDetail $productDetail
     */
    public function __construct(ProductDetail $productDetail)
    {
        //
        $this->productDetail = $productDetail;
    }

}
