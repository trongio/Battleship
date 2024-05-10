<?php

namespace App\Listeners;

use App\Events\SendMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Laravel\Reverb\Events\MessageReceived;

class BroadcastMessage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageReceived $event): void
    {
        $message = json_decode($event->message);

        if (isset($message->event) && $message->event == 'SendMessage') {
            $data = json_decode($message->data);
            broadcast(new SendMessage($data->message))->toOthers();
        }
    }
}
