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
use App\Singleton\PostTypes;
use App\Singleton\WeekDayPost;

class WeekDayPostBuilder
{
    public static function build(string $day): RedditPost
    {
        switch ($day) {
            case 'Monday':
                $post_data = WeekDayPost::MONDAY;
                break;
            case 'Tuesday':
                $post_data = WeekDayPost::TUESDAY;
                break;
            case 'Wednesday':
                $post_data = WeekDayPost::WEDNESDAY;
                break;
            case 'Thursday':
                $post_data = WeekDayPost::THURSDAY;
                break;
            case 'Friday':
                $post_data = WeekDayPost::FRIDAY;
                break;
            default:
                $post_data = [];
        }

        return new RedditPost($post_data['title'], $post_data['text'], PostTypes::WEEKDAY_POST);
    }
}
