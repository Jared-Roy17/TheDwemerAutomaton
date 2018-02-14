<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 08.02.18
 * Time: 15:53.
 */

namespace App\Builders;

use App\RedditPost;

class ModNotificationBuilder
{
    /**
     * Builds a notification for moderators of a posted RedditPost.
     *
     * @param RedditPost $post
     *
     * @return string
     */
    public static function build(RedditPost $post): string
    {
        $now     = new \DateTime();
        $options = [];

        if ($post->isDistinguished()) {
            $options[] = 'Distinguished';
        }

        if ($post->isSticky()) {
            $options[] = 'Stickied (slot '.$post->getStickySlot().')';
        }

        if ($post->isContestMode()) {
            $options[] = 'Contest Mode';
        }

        if (!empty($post->getSort())) {
            $options[] = 'Suggested Sort ('.$post->getSort().')';
        }

        $m = 'Successfully posted <'.$post->getUrl().'|'.$post->getTitle().'> on '.$now->format('F jS Y, H:i').' ('.env('APP_TIMEZONE').').'.PHP_EOL;
        if (count($options) > 0) {
            $m .= 'ENABLED OPTIONS: '.implode(', ', $options).'.';
        }

        return $m;
    }
}
