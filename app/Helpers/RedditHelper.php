<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 03.02.18
 * Time: 22:29.
 */

namespace App\Helpers;

class RedditHelper
{
    private $apiHost = 'https://ssl.reddit.com/api';
    private $modHash = null;
    private $session = null;

    /**
     * RedditHelper constructor.
     */
    public function __construct()
    {
        $username = env('REDDIT_USERNAME');
        $password = env('REDDIT_PASSWORD');

        $urlLogin = "{$this->apiHost}/login/$username";

        $postData = sprintf('api_type=json&user=%s&passwd=%s',
            $username,
            $password);
        $response = $this->runCurl($urlLogin, $postData);

        $this->modHash = $response->json->data->modhash;
        $this->session = $response->json->data->cookie;
    }

    /**
     * @param null $title
     * @param null $text
     * @param null $subreddit
     */
    public function createStory($title = null, $text = null, $subreddit = null)
    {
        $urlSubmit = "{$this->apiHost}/submit";

        if (empty($title)) {
            echo 'title empty';
        }

        $kind = 'self';

        $postData = sprintf('uh=%s&kind=%s&sr=%s&title=%s&r=%s&sendreplies&renderstyle=html',
            $this->modHash,
            $kind,
            $subreddit,
            urlencode($title),
            $subreddit,
            false);

        //if link was present, add to POST data
        if (null != $text) {
            $postData .= '&text='.urlencode($text);
        }

        $response = $this->runCurl($urlSubmit, $postData);

        if (!empty($response->jquery[10][3][0])) {
            return $response->jquery[10][3][0];
        }

        return null;
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function distinguish(string $id)
    {
        $urlMessages = "{$this->apiHost}/distinguish";

        $postData = sprintf('uh=%s&api_type=%s&how=%s&id=%s',
            $this->modHash,
            'json',
            'yes',
            't3_'.$id);

        return $this->runCurl($urlMessages, $postData);
    }

    /**
     * @param $url
     * @param null $postVals
     *
     * @return mixed
     */
    private function runCurl($url, $postVals = null)
    {
        $ch = curl_init($url);

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIE         => "reddit_session={$this->session}",
            CURLOPT_TIMEOUT        => 3,
        ];

        if (null != $postVals) {
            $options[CURLOPT_POSTFIELDS]    = $postVals;
            $options[CURLOPT_CUSTOMREQUEST] = 'POST';
        }

        curl_setopt_array($ch, $options);

        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;
    }
}
