<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 23.02.18
 * Time: 16:27.
 */

namespace App\Http\Controllers;

use App\RedditPost;
use App\Singleton\PostTypes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function incoming(Request $request)
    {
        if (!$this->checkToken($request)) {
            return response('FORBIDDEN', Response::HTTP_FORBIDDEN);
        }

        $title = $request->input('title');
        $url   = $request->input('url');

        $post = new RedditPost($title, $url, PostTypes::NEWS_POST);

        $post->postUrl()->distinguish();

        $post->notifyModSlack();

        return response('ACCEPTED', Response::HTTP_ACCEPTED);
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function checkToken(Request $request): bool
    {
        $header = str_replace('Basic ', '', $request->header('Authorization'));
        $header = base64_decode($header);

        if (1 === DB::table('auth')->where('token', '=', $header)->count()) {
            return true;
        }

        return false;
    }
}
