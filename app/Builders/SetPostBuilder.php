<?php

namespace App\Builders;

use App\RedditPost;
use App\Set;
use App\Singleton\PostTypes;
use App\Singleton\WeekDayPost;

/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 03.02.18
 * Time: 21:56.
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

        if (!empty($set->locationEN)) {
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
        $text .= 'Information about this set was provided by [ESO-Sets.com](https://www.eso-sets.com/set/'.$set->slug.').'.WeekDayPost::SIGNATURE;

        return new RedditPost($title, $text, PostTypes::DAILY_SET_POST);
    }
}
