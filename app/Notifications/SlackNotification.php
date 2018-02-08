<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 08.02.18
 * Time: 15:18.
 */

namespace App\Notifications;

class SlackNotification
{
    public static function send(string $text, string $url = null, string $webhook)
    {
        $text = str_replace('&', ' and ', $text);

        if (!empty($url)) {
            $message = '<'.$url.'|'.$text.'>';
        } else {
            $message = $text;
        }

        $toSendSlack = 'payload='.json_encode(['text' => $message]);

        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $toSendSlack);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}
