<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 07.02.18
 * Time: 09:54.
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
