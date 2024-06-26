<?php

namespace App\Notifications\Channels;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WebChannel extends Notification
{
    use Queueable;

    /**
     * Send the given notification.
     */
    public function send(mixed $notifiable, Notification $notification): void
    {
        $data = $notification->toArray($notifiable);

        if (! $data) {
            return;
        }

        $user_id = $notifiable->user_id ?? $notifiable->id;

        $user = (new User)->find($user_id);

        // if ($user) {
        //     // broadcast(new Users($user, $data['event'] ?? 'notification', $data));
        // }
    }
}
