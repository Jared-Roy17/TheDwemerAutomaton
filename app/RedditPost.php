<?php
/**
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
    private $helper;

    private $distinguished = false;
    private $sticky        = false;
    private $stickySlot    = null;
    private $contestMode   = false;
    private $sort          = null;

    /**
     * RedditPost constructor.
     *
     * @param string $title
     * @param string $text
     * @param int    $type
     */
    public function __construct(string $title, string $text, int $type)
    {
        $this->title  = $title;
        $this->text   = $text;
        $this->type   = $type;
        $this->helper = new RedditHelper();
    }

    /**
     * Posts the post to reddit.
     *
     * @return RedditPost
     */
    public function post(): self
    {
        $response = $this->helper->createStory($this->title, $this->text, env('SUBREDDIT'));
        $split    = explode('/', str_replace('https://www.reddit.com/r/'.env('SUBREDDIT').'/comments/', '', $response), 2);

        $this->post_id = $split[0];
        $this->url     = 'https://www.reddit.com/r/'.env('SUBREDDIT').'/comments/'.$this->post_id;

        $this->save();

        return $this;
    }

    /**
     * @return RedditPost
     */
    public function postUrl(): self
    {
        $response = $this->helper->createStory($this->title, $this->text, env('SUBREDDIT'), 'link');
        $split    = explode('/', str_replace('https://www.reddit.com/r/'.env('SUBREDDIT').'/comments/', '', $response), 2);

        $this->post_id = $split[0];
        $this->url     = 'https://www.reddit.com/r/'.env('SUBREDDIT').'/comments/'.$this->post_id;

        return $this;
    }

    /**
     * @return RedditPost
     */
    public function distinguish(): self
    {
        if (empty($this->post_id)) {
            return $this;
        }

        $this->helper->distinguish($this->post_id);
        $this->distinguished = true;

        return $this;
    }

    /**
     * @param int $slot
     *
     * @return RedditPost
     */
    public function setSticky(int $slot = 1): self
    {
        if (empty($this->post_id)) {
            return $this;
        }

        $this->helper->setSticky($this->post_id, $slot);
        $this->sticky     = true;
        $this->stickySlot = $slot;

        return $this;
    }

    /**
     * @return RedditPost
     */
    public function enableContestMode(): self
    {
        if (empty($this->post_id)) {
            return $this;
        }

        $this->helper->setContestMode($this->post_id);
        $this->contestMode = true;

        return $this;
    }

    /**
     * @param string $sort
     *
     * @return RedditPost
     */
    public function setSuggestedSort(string $sort): self
    {
        if (empty($this->post_id)) {
            return $this;
        }

        $this->helper->setSuggestedSort($this->post_id, $sort);
        $this->sort = $sort;

        return $this;
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

        SlackNotification::send(ModNotificationBuilder::build($this), null, env('BOT_MOD_SLACK'));
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
            $set = Set::query()->where('name', '=', str_replace(SetPostBuilder::TITLE_PREFIX, '', $this->title))->first();

            DB::table('sets_done')->insert([
                'date'    => date('Y-m-d'),
                'post_id' => $this->post_id,
                'set_id'  => $set->id,
            ]);
        }

        $this->print();
    }

    public function sendToEsosets()
    {
        if (PostTypes::DAILY_SET_POST === $this->type && !empty($this->post_id)) {
            $set = Set::query()->where('name', '=', str_replace(SetPostBuilder::TITLE_PREFIX, '', $this->title))->first();

            if (!empty($set->id)) {
                $headers = [
                    'Content-Type:application/json',
                    'Authorization: Basic '.base64_encode(env('ESOSETS_API_KEY')), ];

                $ch = curl_init('https://eso-sets.com/api/reddit/setdiscussion/'.$set->id.'/'.$this->post_id);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_exec($ch);
                curl_close($ch);
            }
        }
    }

    public function doCustomRequests(string $channel)
    {
        foreach (CustomRequest::all() as $request) {
            $request->make($this->title, $this->url, $channel);
        }
    }

    /**
     * Prints the post to the console.
     */
    private function print()
    {
        print_r('Posted and Saved: '.$this->title.PHP_EOL);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isDistinguished(): bool
    {
        return $this->distinguished;
    }

    /**
     * @return bool
     */
    public function isSticky(): bool
    {
        return $this->sticky;
    }

    public function getStickySlot()
    {
        return $this->stickySlot;
    }

    /**
     * @return bool
     */
    public function isContestMode(): bool
    {
        return $this->contestMode;
    }

    public function getSort()
    {
        return $this->sort;
    }
}
