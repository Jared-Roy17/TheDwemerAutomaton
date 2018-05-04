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
    protected $table = 'eso_sets';

    public function hasJewelry(): bool
    {
        return 1 === $this->has_jewels;
    }

    public function hasWeapons(): bool
    {
        return 1 === $this->has_weapons;
    }

    public function isLight(): bool
    {
        return 1 === $this->has_light_armor;
    }

    public function isMedium(): bool
    {
        return 1 === $this->has_medium_armor;
    }

    public function isHeavy(): bool
    {
        return 1 === $this->has_heavy_armor;
    }

    public function getSetBonusses(): array
    {
        $formatted = [];

        if (!empty($this->bonus_item_1)) {
            $formatted[1] = $this->bonus_item_1;
        }
        if (!empty($this->bonus_item_2)) {
            $formatted[2] = $this->bonus_item_2;
        }
        if (!empty($this->bonus_item_3)) {
            $formatted[3] = $this->bonus_item_3;
        }
        if (!empty($this->bonus_item_4)) {
            $formatted[4] = $this->bonus_item_4;
        }
        if (!empty($this->bonus_item_5)) {
            $formatted[5] = $this->bonus_item_5;
        }

        return $formatted;
    }
}
