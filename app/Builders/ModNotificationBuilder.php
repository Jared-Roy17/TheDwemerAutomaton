<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 08.02.18
 * Time: 15:53.
 */

namespace App\Builders;

class ModNotificationBuilder
{
    /**
     * Builds a notification for moderators of a posted RedditPost.
     *
     * @param string $title
     * @param string $url
     *
     * @return string
     */
    public static function build(string $title, string $url): string
    {
        $now = new \DateTime();

        return 'Successfully posted <'.$url.'|'.$title.'> on '.$now->format('F jS Y, H:i').' ('.env('APP_TIMEZONE').').';
    }
}
