<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 03.02.18
 * Time: 21:57.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $table = 'sets_new';

    public function hasJewelry(): bool
    {
        return 1 === $this->hasJewelry;
    }

    public function hasWeapons(): bool
    {
        return 1 === $this->hasWeapons;
    }

    public function isLight(): bool
    {
        return 1 === $this->isLight;
    }

    public function isMedium(): bool
    {
        return 1 === $this->isMedium;
    }

    public function isHeavy(): bool
    {
        return 1 === $this->isHeavy;
    }

    public function getSetBonusses(): array
    {
        $bonusses  = explode('<br>', $this->bonusEN);
        $formatted = [];

        $replace = [
            '(1 item)'  => '',
            '(2 items)' => '',
            '(3 items)' => '',
            '(4 items)' => '',
            '(5 items)' => '',
        ];

        foreach ($bonusses as $bonus) {
            if (false !== strpos($bonus, '(1 item)')) {
                $bonus        = strtr($bonus, $replace);
                $formatted[1] = $bonus;
            }
            if (false !== strpos($bonus, '(2 items)')) {
                $bonus        = strtr($bonus, $replace);
                $formatted[2] = $bonus;
            }
            if (false !== strpos($bonus, '(3 items)')) {
                $bonus        = strtr($bonus, $replace);
                $formatted[3] = $bonus;
            }
            if (false !== strpos($bonus, '(4 items)')) {
                $bonus        = strtr($bonus, $replace);
                $formatted[4] = $bonus;
            }
            if (false !== strpos($bonus, '(5 items)')) {
                $bonus        = strtr($bonus, $replace);
                $formatted[5] = $bonus;
            }
        }

        return $formatted;
    }
}
