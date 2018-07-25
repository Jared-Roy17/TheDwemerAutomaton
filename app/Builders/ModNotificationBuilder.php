<?php
/*
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

        $m = 'Successfully posted *<'.$post->getUrl().'|'.$post->getTitle().'>* on '.$now->format('F jS Y, H:i').' ('.env('APP_TIMEZONE').').'.PHP_EOL;
        if (count($options) > 0) {
            $m .= '*ENABLED OPTIONS:* '.implode(', ', $options).'.';
        }

        return $m;
    }
}
