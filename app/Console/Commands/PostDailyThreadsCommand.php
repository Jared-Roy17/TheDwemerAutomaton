<?php

namespace App\Console\Commands;

use App\Builders\SetPostBuilder;
use App\Builders\WeekDayPostBuilder;
use App\Set;
use App\Singleton\PostTypes;
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

        if (($now > $atTenAm)
            && 'Saturday' !== date('l')
            && 'Sunday' !== date('l')) {
            if (PostTypes::isEnabled(PostTypes::DAILY_SET_POST_TEXT)
                && !PostTypes::hasTodayBeenPosted(PostTypes::DAILY_SET_POST_TEXT)) {
                $sets_posted = DB::table('sets_done')->get()->all();

                $ids = [];

                /** @var array $sets_posted */
                foreach ($sets_posted as $set) {
                    $ids[] = $set->set_id;
                }

                $new_set = Set::query()->whereNotIn('id', $ids)->orderBy('sort_order', 'asc')->first();

                /** @var Set $new_set */
                $post = SetPostBuilder::build($new_set);

                $post->post(true);

                if (env('APP_NOTIFICATIONS')) {
                    $post->sendToDiscord();
                    $post->notifyModSlack();
                }
            }

            if (PostTypes::isEnabled(PostTypes::WEEKDAY_POST_TEXT)
                && !PostTypes::hasTodayBeenPosted(PostTypes::WEEKDAY_POST_TEXT)) {
                $post = WeekDayPostBuilder::build(date('l'));

                $post->post(true);

                if (env('APP_NOTIFICATIONS')) {
                    $post->sendToDiscord();
                    $post->notifyModSlack();
                }
            }
        }

        return true;
    }
}
