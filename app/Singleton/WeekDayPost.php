<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 03.02.18
 * Time: 20:26.
 */

namespace App\Singleton;

class WeekDayPost
{
    const SIGNATURE = '\n &nbsp; \n" . "\n I was programmed to write posts automatically by /u/Woeler. If you have any questions or suggestions about me or my posts, please contact him.';

    const MONDAY = [
        'title' => 'Mages Guild Monday - Share Your ESO Knowledge, Ask Questions, Get Info If You\'re New!',
        'text'  => 'Hey folks,\n\n Welcome to **[Mages Guild](http://elderscrolls.wikia.com/wiki/Mages_Guild) Monday**, a community-building, regularly occurring thread on the subreddit!\n\n **Mages Guild Monday** is a thread aimed at sharing tips, tricks, knowledge and information about the game.\n\n Know of a place that yields a particularly good reward? Got a tip about how to most efficiently accomplish quests? Have some good intel on good ways to serve your alliance in PvP? Let the community know!\n\n In addition, if you\'re new to following the game, this thread is your chance to ask questions and get help from veteran players.\n\n Please keep in mind the \'no personal attacks\' rule in our sidebar, disagree respectfully with others, and know that a repeated or seemingly obvious bit of knowledge may not be obvious to everyone.\n\n We look forward to your contributions!'.self::SIGNATURE,
    ];

    const TUESDAY = [
        'title' => 'Trade Tuesdays - Post your ESO trades here!',
        'text'  => 'Hey folks,\n\n Welcome to our new recurring post to help you trade items in ESO!\n\n You can post any ingame items you would like to sell, buy or trade, start your comment with WTS / WTB / WTT.\n\n Please do not post trades for out of game items / cash, or anything that may break the ESO Terms of Service.\n\n As always, be polite and respectful, and happy trading!'.self::SIGNATURE,
    ];

    const WEDNESDAY = [
        'title' => 'Workshop Wednesday - Give Crafting Tips, Offer Services, Help Your Fellow Crafters!',
        'text'  => 'Hey folks,\n\n Welcome to **Workshop Wednesday**, a community-building, regularly occurring thread on the subreddit!\n\n **Workshop Wednesday** is a thread aimed at all things crafting, from sharing tips and knowledge, providing assistance, or offering crafting services to others.\n\n Got a way to get more of those pesky crafting mats into your inventory? Have a rare recipe you\'re willing to produce for others? Just want to help with crafting as a whole? Let the community know here!\n\n Crafting is a deep system in The Elder Scrolls Online with multiple professions, so be sure to participate in the thread whether you\'re a crafting novice or a master at sweetroll baking.\n\n Please keep in mind the \'no personal attacks\' rule in our sidebar, disagree respectfully with others, and know that a repeated or seemingly obvious bit of knowledge may not be obvious to everyone.\n\n In addition, please be careful about posting in-game information about your account name/characters for conducting crafting business. We recommend contact information be shared privately to keep your account secure.\n\n We look forward to your contributions!'.self::SIGNATURE,
    ];

    const THURSDAY = [
        'title' => 'Theorycraft Thursday - Discuss Builds, Skills, Strategies, and More!',
        'text'  => 'Welcome to **Theorycraft Thursday**, a community-building, regularly occurring thread in the subreddit!\n\n MMO veterans will know that Theorycrafting is the core of many discussions about this genre of games, and ESO is no different.\n\n With the high level of variance in builds, skills, and stats, there\'s plenty of room for Theorycrafting, and we want to see what you have to share with the community on that front.\n\n Have a build you\'ve experimented with? A particular skill or set of skills that synergize well? A strategy for PvE or PvP that works to great effect? Share it here!\n\n If you\'re new, you can also use this thread to ask questions about viable builds and skills as well!\n\n As always, please keep in mind our rules on the sidebar, especially the one about \'no personal attacks, callouts, rude behavior, or other such disrespectful content\'.\n\n Disagree respectfully and know that everyone has different ideas and playstyles that suit them.'.self::SIGNATURE,
    ];

    const FRIDAY = [
        'title' => 'Guild Fair Friday - Advertise your guild, Find a guild!',
        'text'  => 'Hey folks,\n\n Welcome to our new recurring post to help you find a guild on the subreddit!\n\n";
                $text .= "If you have a guild, you\'re allowed to post ONCE. If you\'re looking for a guild, you can also post. Your post should have - \n\n1) Server (NA or EU), Faction (if applicable), and Type of Guild (Social, PvE, PvP, Hardcore Endgame, Trade, Mixed)\n\n For recruiters, also include \n\n2) Current member numbers \n\n3) Guild recruiting message \n\n4) How to apply\n\n As always, be polite and respectful, and good luck finding a guild!'.self::SIGNATURE,
    ];
}
