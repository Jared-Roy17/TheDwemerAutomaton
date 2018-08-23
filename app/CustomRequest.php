<?php
/**
 * This file is part of the ESO-Database project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 * @see https://eso-database.com
 * Created by woeler
 * Date: 22.08.18
 * Time: 13:03
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomRequest extends Model
{
    protected $table = 'custom_requests';

    public function make(string $title, $url = null, string $channel)
    {
        $toSend = [
            'title'   => $title,
            'url'     => $url,
            'channel' => $channel,
        ];

        if (null !== $this->token) {
            $toSend['token'] = $this->token;
        }

        // use key 'http' even if you send the request to https://...
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($toSend),
            ],
        ];
        $context  = stream_context_create($options);
        $result   = file_get_contents($this->url, false, $context);
    }
}
