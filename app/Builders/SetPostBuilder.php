<?php

namespace App\Builders;

use App\RedditPost;
use App\Set;
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

    public function build(Set $set): RedditPost
    {
        $title = self::TITLE_PREFIX.$set->nameEN;

        $text = '**'.$set->nameEN.'**\n\n';

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

        $text .= '*Obtainable as: '.implode(', ', $types).'*\n\n';
        $text .= '*Type: '.$set->type.'*\n\n';

        if (!empty($set->locationEN)) {
            $text .= '*Location: '.str_replace(';', ', ', $set->locationEN).'*\n\n';
        }

        $text .= '\n &nbsp; \n\n';
        $text .= '***Set Bonuses***\n\n';
        $text .= 'Items | Bonus\n';
        $text .= '---|---\n';

        foreach ($set->getSetBonusses() as $key => $bonus) {
            $text .= $key.' | '.$bonus.'\n';
        }

        $text .= '\n &nbsp; \n\n';
        $text .= '*Be sure to think about strengths, weaknesses, counters, and synergies in your discussions. Please vote based on contribution, not opinion.*\n\n';
        $text .= '\n &nbsp; \n\n';
        $text .= 'Information about this set was provided by [ElderScrollsBote](https://www.elderscrollsbote.de/).'.WeekDayPost::SIGNATURE;

        return new RedditPost($title, $text);
    }
}
