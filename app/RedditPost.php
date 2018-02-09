<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 03.02.18
 * Time: 22:24.
 */

namespace App;

use App\Builders\ModNotificationBuilder;
use App\Builders\SetPostBuilder;
use App\Helpers\RedditHelper;
use App\Notifications\DiscordNotification;
use App\Notifications\SlackNotification;
use App\Singleton\PostTypes;
use Illuminate\Support\Facades\DB;

class RedditPost
{
    private $title;
    private $text;
    private $type;
    private $post_id;
    private $url;

    /**
     * RedditPost constructor.
     *
     * @param string $title
     * @param string $text
     * @param int    $type
     */
    public function __construct(string $title, string $text, int $type)
    {
        $this->title = $title;
        $this->text  = $text;
        $this->type  = $type;
    }

    /**
     * Distinguishes the post if the user has the rights to do so.
     *
     * @param bool $distinguish
     */
    public function post(bool $distinguish = false)
    {
        $helper   = new RedditHelper();
        $response = $helper->createStory($this->title, $this->text, env('SUBREDDIT'));
        $split    = explode('/', str_replace('https://www.reddit.com/r/'.env('SUBREDDIT').'/comments/', '', $response), 2);

        $this->post_id = $split[0];
        $this->url     = 'https://www.reddit.com/r/'.env('SUBREDDIT').'/comments/'.$this->post_id;

        if ($distinguish) {
            $helper->distinguish($this->post_id);
        }

        $this->save();
    }

    /**
     * Sends a notification of the post to Discord.
     */
    public function sendToDiscord()
    {
        DiscordNotification::send($this->title, $this->url, env('BOT_SUBREDDIT_DISCORD'));
    }

    /**
     * Notifies the moderator slack about this post.
     */
    public function notifyModSlack()
    {
        if (empty($this->url)) {
            return;
        }

        SlackNotification::send(ModNotificationBuilder::build($this->title, $this->url), null, env('BOT_MOD_SLACK'));
    }

    /**
     * Saves the post into the database.
     */
    private function save()
    {
        if (PostTypes::WEEKDAY_POST === $this->type) {
            DB::table('posts_done')->insert([
                'date'    => date('Y-m-d'),
                'post_id' => $this->post_id,
            ]);
        } elseif (PostTypes::DAILY_SET_POST === $this->type) {
            $set = Set::query()->where('nameEN', '=', str_replace(SetPostBuilder::TITLE_PREFIX, '', $this->title))->first();

            DB::table('sets_done')->insert([
                'date'    => date('Y-m-d'),
                'post_id' => $this->post_id,
                'set_id'  => $set->id,
            ]);
        }

        $this->print();
    }

    /**
     * Prints the post to the console.
     */
    private function print()
    {
        print_r('Posted and Saved: '.$this->title.PHP_EOL);
    }
}
