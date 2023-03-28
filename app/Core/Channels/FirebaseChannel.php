<?php

namespace App\Core\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

/**
 *
 */
class FirebaseChannel
{
    public function send($notifiable, Notification $notification)
    {

        $payload = $notification->toFirebase($notifiable);
        $fields = $this->prepareFields($notifiable, $payload);
        $data = [
            "priority" => "high",
            "content_available" => true,
            "notification" => [
                "title" => $fields['notification']['title'],
                "body" => $fields['notification']['body']
            ],

            "data" => [
                "type" => $fields['data']['type'],
                "id" =>  $fields['data']['id'],
                "alarm" => $fields['data']['alarm'],
                "title" =>  $fields['data']['title'],

            ],
            "to" => $fields['to']

        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=AAAAmKTsKuc:APA91bG0yVAVwulAFv-PkAqL65ZoLcTMPeDphLyjS3VCoSsu65iLCKlq-uBIZl9oPXmpkEwfkdVGD9tEPrFWhW62dJZF6kx4UgJQcB_OfZCYhLCzxHZioxlcyqm9vZe8gqWalpJvS1dr',
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $data);
        return $response->json($response);
    }

    private function prepareFields($notifiable, $payload)
    {

        $tokens = $notifiable->tokens()->where('revoked', 0)->pluck('device_token')->all();
        $tokens = $notifiable->device_token;
        $fields = [
            'to' => $tokens,
        ];
        return array_merge($payload, $fields);
    }
}
