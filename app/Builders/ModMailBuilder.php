<?php
/*
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

namespace App\Builders;

class ModMailBuilder
{
    /**
     * Builds a human readable notification from a modmail array.
     *
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
