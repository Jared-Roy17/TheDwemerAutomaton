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

        $urlLogin = $this->apiHost.'/login/'.$username;

        $postData = sprintf('api_type=json&user=%s&passwd=%s',
            $username,
            $password);
        $response = $this->runCurl($urlLogin, $postData);

        $this->modHash = $response->json->data->modhash;
        $this->session = $response->json->data->cookie;
    }

    /**
     * @param null   $title
     * @param null   $text
     * @param null   $subreddit
     * @param string $kind
     */
    public function createStory($title = null, $text = null, $subreddit = null, $kind = 'self')
    {
        $urlSubmit = $this->apiHost.'/submit';

        if (empty($title)) {
            echo 'title empty';
        }

        $postData = [
            'uh'          => $this->modHash,
            'kind'        => $kind,
            'sr'          => $subreddit,
            'title'       => $title,
            'r'           => $subreddit,
            'renderstyle' => 'html',
            'sendreplies' => false,
        ];

        //if link was present, add to POST data
        if (null != $text && 'self' === $kind) {
            $postData['text'] = $text;
        } elseif (null != $text && 'link' === $kind) {
            $postData['url'] = $text;
        }

        $response = $this->runCurl($urlSubmit, $postData);

        if ('self' === $kind && !empty($response->jquery[10][3][0])) {
            return $response->jquery[10][3][0];
        } elseif ('link' === $kind && !empty($response->jquery[16][3][0])) {
            return $response->jquery[16][3][0];
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
        $urlMessages = $this->apiHost.'/distinguish';

        $postData = [
            'uh'       => $this->modHash,
            'api_type' => 'json',
            'how'      => 'yes',
            'id'       => 't3_'.$id,
        ];

        return $this->runCurl($urlMessages, $postData);
    }

    /**
     * @param string $id
     * @param int    $stickySlot
     */
    public function setSticky(string $id, int $stickySlot)
    {
        $urlMessages = $this->apiHost.'/set_subreddit_sticky';

        $postData = [
            'uh'         => $this->modHash,
            'api_type'   => 'json',
            'id'         => 't3_'.$id,
            'num'        => $stickySlot,
            'state'      => true,
            'to_profile' => false,
        ];

        $this->runCurl($urlMessages, $postData);
    }

    /**
     * @param string $id
     */
    public function setContestMode(string $id)
    {
        $urlMessages = $this->apiHost.'/set_contest_mode';

        $postData = [
            'uh'       => $this->modHash,
            'api_type' => 'json',
            'id'       => 't3_'.$id,
            'state'    => true,
        ];

        $this->runCurl($urlMessages, $postData);
    }

    /**
     * @param string $id
     * @param string $sort
     */
    public function setSuggestedSort(string $id, string $sort)
    {
        $urlMessages = $this->apiHost.'/set_suggested_sort';

        $postData = [
            'uh'       => $this->modHash,
            'api_type' => 'json',
            'id'       => 't3_'.$id,
            'sort'     => $sort,
        ];

        $this->runCurl($urlMessages, $postData);
    }

    /**
     * @param string $pageName
     *
     * @return mixed
     */
    public function getWikiPage(string $pageName)
    {
        $urlMessage = 'https://reddit.com/r/'.env('SUBREDDIT').'/wiki/'.$pageName.'.json';

        return $this->runGet($urlMessage)['data']['content_md'];
    }

    /**
     * @param string $pageName
     * @param string $content
     */
    public function editWikiPage(string $pageName, string $content)
    {
        $urlMessage = 'https://reddit.com/r/'.env('SUBREDDIT').'/api/wiki/edit';

        $current_revision = $this->wikiGetPageRevisions($pageName, 1);
        if (isset($current_revision['data']['children'][0])) {
            $previous = $current_revision['data']['children'][0]['id'];
        }

        $postData = [
            'uh'       => $this->modHash,
            'page'     => $pageName,
            'content'  => $content,
            'previous' => $previous,
            'reason'   => 'test',
        ];

        $this->runCurl($urlMessage, $postData);
    }

    /**
     * @param $pageName
     * @param int  $limit
     * @param null $after
     * @param null $before
     *
     * @return mixed
     */
    private function wikiGetPageRevisions($pageName, $limit = 25, $after = null, $before = null)
    {
        $params = [
            'after'  => $after,
            'before' => $before,
            'limit'  => $limit,
            'show'   => 'all',
        ];

        $urlMessage = 'https://reddit.com/r/'.env('SUBREDDIT').'/wiki/revisions/'.$pageName.'.json?'.http_build_query($params);

        return $this->runGet($urlMessage);
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
            CURLOPT_COOKIE         => 'reddit_session='.$this->session,
            CURLOPT_TIMEOUT        => 3,
        ];

        if (null != $postVals) {
            $options[CURLOPT_POSTFIELDS]    = $postVals;
            $options[CURLOPT_CUSTOMREQUEST] = 'POST';
        }

        curl_setopt_array($ch, $options);

        $runCurl = curl_exec($ch);

        while (false === $runCurl) {
            sleep(5);
            $runCurl = curl_exec($ch);
        }

        $response = json_decode($runCurl);

        curl_close($ch);

        return $response;
    }

    private function runGet(string $url)
    {
        return json_decode(file_get_contents($url), true);
    }
}
