<?php
/**
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
