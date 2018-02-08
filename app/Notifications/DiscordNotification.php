<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 08.02.18
 * Time: 15:43.
 */

namespace App\Notifications;

class DiscordNotification
{
    public static function send(string $text, string $url = null, string $webhook)
    {
        $text = str_replace('&', ' and ', $text);
        if (!empty($url)) {
            $message = '['.$text.']('.$url.')';
        } else {
            $message = $text;
        }

        $toSendDiscord = json_encode([
            'content'    => $message,
            'username'   => env('BOT_USERNAME'),
            'avatar_url' => env('BOT_AVATAR'),
        ]);

        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $toSendDiscord);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}
