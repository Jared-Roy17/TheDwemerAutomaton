<?php

namespace App\Builders;

use App\RedditPost;
use App\Set;
use App\Singleton\PostTypes;
use App\Singleton\WeekDayPost;

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

class SetPostBuilder
{
    const TITLE_PREFIX = '[Daily] Set Discussion: ';

    /**
     * Builds a RedditPost from a Set.
     *
     * @param Set $set
     *
     * @return RedditPost
     */
    public static function build(Set $set): RedditPost
    {
        $title = self::TITLE_PREFIX.$set->name;

        $text = '**'.$set->name.'**'.PHP_EOL.PHP_EOL;

        $types = [];

        if ($set->hasJewelry()) {
            $types[] = 'Jewels';
        }
        if ($set->hasWeapons()) {
            $types[] = 'Weapons';
        }
        if ($set->isMedium()) {
            $types[] = 'Medium Armor';
        }
        if ($set->isLight()) {
            $types[] = 'Light Armor';
        }
        if ($set->isHeavy()) {
            $types[] = 'Heavy Armor';
        }

        $text .= '*Obtainable as: '.implode(', ', $types).'*'.PHP_EOL.PHP_EOL;
        $text .= '*Type: '.$set->type.'*'.PHP_EOL.PHP_EOL;
        if ('Craftable' === $set->type) {
            $text .= '*Traits needed to craft: '.$set->traits_needed.'*'.PHP_EOL.PHP_EOL;
        }

        if (!empty($set->location)) {
            $text .= '*Location: '.$set->location.'*'.PHP_EOL.PHP_EOL;
        }

        $text .= PHP_EOL.' &nbsp; '.PHP_EOL.PHP_EOL;
        $text .= '***Set Bonuses***'.PHP_EOL.PHP_EOL;
        $text .= 'Items | Bonus'.PHP_EOL;
        $text .= '---|---'.PHP_EOL;

        foreach ($set->getSetBonusses() as $key => $bonus) {
            $text .= $key.' | '.$bonus.PHP_EOL;
        }

        $text .= PHP_EOL.' &nbsp; '.PHP_EOL.PHP_EOL;
        $text .= '*Be sure to think about strengths, weaknesses, counters, and synergies in your discussions. Please vote based on contribution, not opinion.*'.PHP_EOL.PHP_EOL;
        $text .= PHP_EOL.' &nbsp; '.PHP_EOL.PHP_EOL;
        $text .= 'Information about this set was provided by [ESO-Sets.com](https://www.eso-sets.com/set/'.$set->slug.').';
        $text .= PHP_EOL.' &nbsp; '.PHP_EOL.PHP_EOL;
        $text .= 'You can find the archive of daily set discussions [here](https://eso-sets.com/reddit/setdiscussion).'
        .WeekDayPost::SIGNATURE;

        return new RedditPost($title, $text, PostTypes::DAILY_SET_POST);
    }
}
