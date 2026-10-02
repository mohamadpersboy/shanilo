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

class UserSuggestedAProduct
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $users;
    /**
     * @var ProductDetail
     */
    private $productDetail;

    /**
     * Create a new event instance.
     *
     * @param $users
     * @param ProductDetail $productDetail
     */
    public function __construct($users,ProductDetail $productDetail)
    {
        //
        $this->users = $users;
        $this->productDetail = $productDetail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return ProductDetail
     */
    public function getProductDetail()
    {
        return $this->productDetail;
    }
}
