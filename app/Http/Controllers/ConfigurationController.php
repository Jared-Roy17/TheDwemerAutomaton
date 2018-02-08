<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 08.02.18
 * Time: 16:02.
 */

namespace App\Http\Controllers;

use App\Notifications\SlackNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    public function slackConfigHook(Request $request)
    {
        if (env('SLACK_COMMAND_TOKEN') !== $request->get('token')) {
            return response('Invalid token.', 401);
        }

        $user_name = $request->get('user_name');
        $setting   = $request->get('text');
        $command   = $request->get('command');

        if ('/disable' === $command || '/enable' === $command) {
            $count = DB::table('config')->where('config_type', '', $setting)->count();

            if (1 === $count) {
                if ('/disable' === $command) {
                    $set        = 0;
                    $set_string = 'disabled';
                }
                if ('/enable' === $command) {
                    $set        = 1;
                    $set_string = 'enabled';
                }

                DB::table('config')->where('config_type', '', $setting)->update(['status' => $set]);

                $text = 'User '.$user_name." changed the configuration for '".$setting."' to ".$set_string.'.';
            } else {
                $text = "The setting '".$setting."' was not found, ".$user_name.'.';
            }

            SlackNotification::send($text, null, env('BOT_MOD_SLACK'));
        } elseif ('/configstatus' === $command) {
            $configs = DB::table('config')->orderBy('config_type')->get()->all();

            $text = 'Known configs:'.PHP_EOL;

            foreach ($configs as $config) {
                if (0 === $config->status) {
                    $text .= $config->config_type.' | DISABLED'.PHP_EOL;
                } elseif (1 === $config->status) {
                    $text .= $config->config_type.' | ENABLED'.PHP_EOL;
                }
            }

            SlackNotification::send($text, null, env('BOT_MOD_SLACK'));
        }
    }
}
