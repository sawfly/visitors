<?php

namespace Sawfly\Visitors\Events;

use App\Events\Event;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConnectionEvent extends Event
{
    use SerializesModels;

    private $request;

    /**
     * ConnectionEvent constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
