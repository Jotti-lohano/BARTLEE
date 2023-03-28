<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AdminNotify extends Notification
{
    use Queueable;
    private $details;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
    

    public function via($notifiable)
    {
         return ['database'];
    }

    public function toMail($notifiable)
    {
         return (new MailMessage)
                    ->greeting($this->details['greeting'])
                    ->line($this->details['body'])
                    ->line($this->details['thanks']);
                   
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->details['message'],
            'title' => $this->details['title'],
            'id' => $this->details['id']??"",
            'route' => $this->details['route'],
        ];
    }

    public function toBroadCast(){
        return new BroadcastMessage([
            'id' => $this->payload['id']??'',
            'data' => [
                'title' => $this->payload['title'],
                'message' => $this->payload['message'],
                'route' => $this->payload['route'],
            ],
            'created_at' => now(),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
