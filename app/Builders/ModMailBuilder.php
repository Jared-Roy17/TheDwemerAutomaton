<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 08.02.18
 * Time: 15:21.
 */

namespace App\Builders;

class ModMailBuilder
{
    /**
     * @param array $modMailData
     *
     * @return string
     */
    public static function build(array $modMailData): string
    {
        $m = '*A new modmail arrived!*'.PHP_EOL;
        $m .= '*Title:* '.$modMailData['data']['subject'].PHP_EOL;
        $m .= '*Sender:* '.$modMailData['data']['author'].PHP_EOL;
        $m .= '*Message:*'.PHP_EOL;
        $m .= $modMailData['data']['body'].PHP_EOL.PHP_EOL;
        $m .= '<https://mod.reddit.com/mail/all|Click here to go to ModMail>';

        return $m;
    }
}
