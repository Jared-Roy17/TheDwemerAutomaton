<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 08.02.18
 * Time: 15:26.
 */

namespace App\Console\Commands;

use App\Builders\ModMailBuilder;
use App\Notifications\SlackNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckModMailCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'check:modmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for new modmail and send it to Slack';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = json_decode(file_get_contents(env('MODMAIL_JSON_URL')), true);

        $cron_data = DB::table('cron_status')->where('type', '=', 'reddit')->first();

        $last_checked = 0;

        $mods = explode(',', env('MODS'));

        foreach ($data['data']['children'] as $mail) {
            if ($mail['data']['subreddit'] === env('SUBREDDIT')) {
                if ($mail['data']['created'] > $cron_data->value) {
                    if ($mail['data']['created'] > $last_checked) {
                        $last_checked = $mail['data']['created'];
                    }

                    if (true !== in_array($mail['data']['author'], $mods, false)) {
                        $text = ModMailBuilder::build($mail);

                        SlackNotification::send($text, null, env('MODMAIL_SLACK_HOOK'));
                    }
                }
            }
        }

        if (0 !== $last_checked) {
            DB::table('cron_status')->where('type', '=', 'reddit')->update(['value' => $last_checked]);
        }

        return true;
    }
}
