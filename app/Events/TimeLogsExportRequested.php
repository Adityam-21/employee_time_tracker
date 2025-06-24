<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TimeLogsExportRequested
{
    use Dispatchable;

    public $filters;
    public $email;

    public function __construct(array $filters, string $email)
    {
        $this->filters = $filters;
        $this->email = $email;
    }
}
