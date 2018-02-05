<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 03.02.18
 * Time: 22:24.
 */

namespace App;

use App\Builders\SetPostBuilder;
use App\Helpers\RedditHelper;
use App\Singleton\PostTypes;
use Illuminate\Support\Facades\DB;

class RedditPost
{
    private $title;
    private $text;
    private $type;
    private $post_id;

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
     * @param bool $distinguish
     */
    public function post(bool $distinguish = false)
    {
        $helper   = new RedditHelper();
        $response = $helper->createStory($this->title, $this->text, env('SUBREDDIT'));
        $split    = explode('/', str_replace('https://www.reddit.com/r/'.env('SUBREDDIT').'/comments/', '', $response), 2);

        $this->post_id = $split[0];

        if ($distinguish) {
            $helper->distinguish($this->post_id);
        }

        $this->save();
    }

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
    }
}
