<?php

namespace App\Console\Commands;

use App\Builders\SetPostBuilder;
use App\Builders\WeekDayPostBuilder;
use App\Set;
use App\Singleton\PostTypes;
use App\Singleton\WeekDayPost;
use DateTime;
use DateTimeZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 07.02.18
 * Time: 09:11.
 */
class PostDailyThreadsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'post:dailies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post the daily threads';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $atTenAm = new DateTime('today 09:00', new DateTimeZone(env('APP_TIMEZONE')));
        $now     = new DateTime('now', new DateTimeZone(env('APP_TIMEZONE')));

        if (($now > $atTenAm) && 'Saturday' !== date('l') && 'Sunday' !== date('l')) {
            if (PostTypes::isEnabled(PostTypes::DAILY_SET_POST_TEXT)
                && !PostTypes::hasTodayBeenPosted(PostTypes::DAILY_SET_POST_TEXT)) {
                $new_set = $this->getNewSetToPost();
                $post    = SetPostBuilder::build($new_set);

                $post->post()->distinguish()->setSticky(1);

                if (env('APP_NOTIFICATIONS')) {
                    $post->sendToDiscord();
                    $post->notifyModSlack();
                }
            }

            if (PostTypes::isEnabled(PostTypes::WEEKDAY_POST_TEXT)
                && !PostTypes::hasTodayBeenPosted(PostTypes::WEEKDAY_POST_TEXT)) {
                $post = WeekDayPostBuilder::build(date('l'));

                if ($post->getTitle() === WeekDayPost::FRIDAY['title']) {
                    $post->post()->distinguish()->enableContestMode()->setSticky(2);
                } elseif ($post->getTitle() === WeekDayPost::MONDAY['title']) {
                    $post->post()->distinguish()->setSticky(2)->setSuggestedSort('new');
                } else {
                    $post->post()->distinguish()->setSticky(2);
                }

                if (env('APP_NOTIFICATIONS')) {
                    $post->sendToDiscord();
                    $post->notifyModSlack();
                }
            }
        }

        return true;
    }

    /**
     * @return Set
     */
    private function getNewSetToPost(): Set
    {
        $sets_posted = DB::table('sets_done')->get()->all();

        $ids = [];

        /** @var array $sets_posted */
        foreach ($sets_posted as $set) {
            $ids[] = $set->set_id;
        }

        /** @var Set $new_set */
        $new_set = Set::query()->whereNotIn('id', $ids)->orderBy('order', 'asc')->first();

        if (null === $new_set) {
            DB::table('sets_done')->truncate();

            $sets_posted = DB::table('sets_done')->get()->all();

            $ids = [];

            /** @var array $sets_posted */
            foreach ($sets_posted as $set) {
                $ids[] = $set->set_id;
            }

            /** @var Set $new_set */
            $new_set = Set::query()->whereNotIn('id', $ids)->orderBy('sort_order', 'asc')->first();
        }

        return $new_set;
    }
}
