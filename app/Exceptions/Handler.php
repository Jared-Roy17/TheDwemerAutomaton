<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Session\TokenMismatchException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $e
     *
     * @throws Exception
     */
    public function report(Exception $e)
    {
        if ('production' === env('APP_ENV')) {
            if ($this->shouldReport($e)) {
                $str = '----- '.date('Y-m-d H:i:s').' '.env('DEFAULT_TIMEZONE').' -----'.PHP_EOL;
                $str .= 'New `'.get_class($e).'`'.PHP_EOL;
                $str .= '```'.$e->getMessage().'```'.PHP_EOL;
                $str .= '`In '.$e->getFile().' on line '.$e->getLine().'.`';
                $ch = curl_init(env('DEBUG_HOOK'));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
                    [
                        'content'    => $str,
                        'username'   => env('BOT_USERNAME'),
                        'avatar_url' => env('BOT_AVATAR'),
                    ]
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_exec($ch);
                curl_close($ch);
            }
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
    }
}
