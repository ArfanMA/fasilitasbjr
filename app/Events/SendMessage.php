<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class SendMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $actionId;
    public $actionData;

    /**
     * Create a new event instance.
     *
     * @param mixed $actionId
     * @param mixed $actionData
     * @return void
     */
    public function __construct($actionId, $actionData)
    {
        $this->actionId = $actionId;
        $this->actionData = $actionData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('action-channel-one');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'actionId' => $this->actionId,
            'actionData' => $this->actionData,
        ];
    }
}