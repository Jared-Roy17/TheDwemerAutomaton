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
    const SIGNATURE = PHP_EOL.' &nbsp; '.PHP_EOL.PHP_EOL.'[I](https://projects.woeler.eu/reddit_autopost/img/dwemer.jpg) was [programmed](https://github.com/Woeler/TheDwemerAutomaton) to write posts automatically by /u/Woeler. If you have any questions or suggestions about me or my posts, please contact him.';

    const MONDAY = [
        'title' => 'Mages Guild Monday - Share Your ESO Knowledge, Ask Questions, Get Info If You\'re New!',
        'text'  => 'Hey folks,'.PHP_EOL.PHP_EOL.' Welcome to **[Mages Guild](http://elderscrolls.wikia.com/wiki/Mages_Guild) Monday**, a community-building, regularly occurring thread on the subreddit!'.PHP_EOL.PHP_EOL.' **Mages Guild Monday** is a thread aimed at sharing tips, tricks, knowledge and information about the game.'.PHP_EOL.PHP_EOL.' Know of a place that yields a particularly good reward? Got a tip about how to most efficiently accomplish quests? Have some good intel on good ways to serve your alliance in PvP? Let the community know!'.PHP_EOL.PHP_EOL.' In addition, if you\'re new to following the game, this thread is your chance to ask questions and get help from veteran players.'.PHP_EOL.PHP_EOL.' Please keep in mind the \'no personal attacks\' rule in our sidebar, disagree respectfully with others, and know that a repeated or seemingly obvious bit of knowledge may not be obvious to everyone.'.PHP_EOL.PHP_EOL.' We look forward to your contributions!'.self::SIGNATURE,
    ];

    const TUESDAY = [
        'title' => 'Trendy Tuesday - Post your ESO outfits and homes!',
        'text'  => 'Hey folks,'.PHP_EOL.PHP_EOL.' Welcome to our new recurring post where you can show off your fashion in ESO!'.PHP_EOL.PHP_EOL.' Feel free to share your outfit or home creations with the rest of the community.'.PHP_EOL.PHP_EOL.' As always, be polite and respectful, may the fashion be with you!'.self::SIGNATURE,
    ];

    const WEDNESDAY = [
        'title' => 'Workshop Wednesday - Give Crafting Tips, Offer Services, Help Your Fellow Crafters!',
        'text'  => 'Hey folks,'.PHP_EOL.PHP_EOL.' Welcome to **Workshop Wednesday**, a community-building, regularly occurring thread on the subreddit!'.PHP_EOL.PHP_EOL.' **Workshop Wednesday** is a thread aimed at all things crafting, from sharing tips and knowledge, providing assistance, or offering crafting services to others.'.PHP_EOL.PHP_EOL.' Got a way to get more of those pesky crafting mats into your inventory? Have a rare recipe you\'re willing to produce for others? Just want to help with crafting as a whole? Let the community know here!'.PHP_EOL.PHP_EOL.' Crafting is a deep system in The Elder Scrolls Online with multiple professions, so be sure to participate in the thread whether you\'re a crafting novice or a master at sweetroll baking.'.PHP_EOL.PHP_EOL.' Please keep in mind the \'no personal attacks\' rule in our sidebar, disagree respectfully with others, and know that a repeated or seemingly obvious bit of knowledge may not be obvious to everyone.'.PHP_EOL.PHP_EOL.' In addition, please be careful about posting in-game information about your account name/characters for conducting crafting business. We recommend contact information be shared privately to keep your account secure.'.PHP_EOL.PHP_EOL.' We look forward to your contributions!'.self::SIGNATURE,
    ];

    const THURSDAY = [
        'title' => 'Theorycraft Thursday - Discuss Builds, Skills, Strategies, and More!',
        'text'  => 'Welcome to **Theorycraft Thursday**, a community-building, regularly occurring thread in the subreddit!'.PHP_EOL.PHP_EOL.' MMO veterans will know that Theorycrafting is the core of many discussions about this genre of games, and ESO is no different.'.PHP_EOL.PHP_EOL.' With the high level of variance in builds, skills, and stats, there\'s plenty of room for Theorycrafting, and we want to see what you have to share with the community on that front.'.PHP_EOL.PHP_EOL.' Have a build you\'ve experimented with? A particular skill or set of skills that synergize well? A strategy for PvE or PvP that works to great effect? Share it here!'.PHP_EOL.PHP_EOL.' If you\'re new, you can also use this thread to ask questions about viable builds and skills as well!'.PHP_EOL.PHP_EOL.' As always, please keep in mind our rules on the sidebar, especially the one about no personal attacks, callouts, rude behavior, or other such disrespectful content.'.PHP_EOL.PHP_EOL.' Disagree respectfully and know that everyone has different ideas and playstyles that suit them.'.self::SIGNATURE,
    ];

    const FRIDAY = [
        'title' => 'Guild Fair Friday - Advertise your guild, Find a guild!',
        'text'  => 'Hey folks,'.PHP_EOL.PHP_EOL.' Welcome to our new recurring post to help you find a guild on the subreddit!'.PHP_EOL.PHP_EOL.'If you have a guild, you\'re allowed to post ONCE. If you\'re looking for a guild, you can also post. Your post should have - '.PHP_EOL.PHP_EOL.'1) Platform (PC, XBOX or Playstation), Server (NA or EU), Faction (if applicable), and Type of Guild (Social, PvE, PvP, Hardcore Endgame, Trade, Mixed)'.PHP_EOL.PHP_EOL.' For recruiters, also include '.PHP_EOL.PHP_EOL.'2) Current member numbers '.PHP_EOL.PHP_EOL.'3) Guild recruiting message '.PHP_EOL.PHP_EOL.'4) How to apply'.PHP_EOL.PHP_EOL.' As always, be polite and respectful, and good luck finding a guild!'.self::SIGNATURE,
    ];
}
