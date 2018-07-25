<?php
/**
 * This file is part of the Dwemer Automaton project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * Copyright: Woeler
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * Created by woeler
 * Date: 16.07.18
 * Time: 12:25
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
