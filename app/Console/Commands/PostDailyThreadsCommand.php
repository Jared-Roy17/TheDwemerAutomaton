<?php

use App\Builders\SetPostBuilder;
use App\Builders\WeekDayPostBuilder;
use App\Set;
use App\Singleton\PostTypes;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 07.02.18
 * Time: 09:11.
 */
class PostDailyThreadsCommand
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
        $atTenAm = new DateTime('today 10:00', new DateTimeZone(env('TIMEZONE')));
        $now     = new DateTime('now', new DateTimeZone(env('TIMEZONE')));

        if (($now > $atTenAm)
            && 'Saturday' !== date('l')
            && 'Sunday' !== date('l')) {
            if (PostTypes::isEnabled(PostTypes::DAILY_SET_POST_TEXT)
                && PostTypes::hasTodayBeenPosted(PostTypes::DAILY_SET_POST_TEXT)) {
                $sets_posted = DB::table('sets_done')->get()->all();

                $ids = [];

                foreach ($sets_posted as $set) {
                    $ids[] = $set->set_id;
                }

                $new_set = Set::query()->whereNotIn('id', $ids)->orderBy('setorder', 'asc')->first();

                /** @var Set $new_set */
                $post = SetPostBuilder::build($new_set);

                $post->post(true);
            }

            if (PostTypes::isEnabled(PostTypes::WEEKDAY_POST_TEXT)
                && PostTypes::hasTodayBeenPosted(PostTypes::WEEKDAY_POST_TEXT)) {
                $post = WeekDayPostBuilder::build(date('l'));

                $post->post(true);
            }
        }

        return true;
    }
}
