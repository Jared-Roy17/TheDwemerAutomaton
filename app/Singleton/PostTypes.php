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

namespace App\Singleton;

use Illuminate\Support\Facades\DB;

class PostTypes
{
    const WEEKDAY_POST   = 1;
    const DAILY_SET_POST = 2;
    const NEWS_POST      = 3;

    const WEEKDAY_POST_TEXT   = 'weekday_posts';
    const DAILY_SET_POST_TEXT = 'daily_set_discussion';
    const NEWS_POST_TEXT      = 'news_posts';

    public static function isEnabled(string $postType): bool
    {
        $setting = DB::table('config')->where('config_type', '=', $postType)->first();

        return 1 === (int) $setting->status;
    }

    public static function hasTodayBeenPosted(string $postType): bool
    {
        $count = 0;

        if (self::DAILY_SET_POST_TEXT === $postType) {
            $count = DB::table('sets_done')->where('date', '=', date('Y-m-d'))->count();
        } elseif (self::WEEKDAY_POST_TEXT === $postType) {
            $count = DB::table('posts_done')->where('date', '=', date('Y-m-d'))->count();
        }

        return 1 === $count;
    }
}
