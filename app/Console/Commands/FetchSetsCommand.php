<?php
/**
 * Created by PhpStorm.
 * User: woeler
 * Date: 08.02.18
 * Time: 15:26.
 */

namespace App\Console\Commands;

use App\Set;
use Illuminate\Console\Command;

class FetchSetsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'fetch:sets';

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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://eso-sets.com/api/sets');
        $headers = [
            'Content-Type:application/json',
            'Authorization: Basic '.base64_encode(env('ESOSETS_API_KEY')), ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        foreach (json_decode($output, true) as $set_new) {
            $db = Set::query()->find($set_new['id']);
            if (empty($db)) {
                $set                   = new Set();
                $set->id               = $set_new['id'];
                $set->name             = $set_new['name'];
                $set->location         = $set_new['location'];
                $set->type             = $set_new['type'];
                $set->slug             = $set_new['slug'];
                $set->bonus_item_1     = $set_new['bonus_item_1'];
                $set->bonus_item_2     = $set_new['bonus_item_2'];
                $set->bonus_item_3     = $set_new['bonus_item_3'];
                $set->bonus_item_4     = $set_new['bonus_item_4'];
                $set->bonus_item_5     = $set_new['bonus_item_5'];
                $set->has_jewels       = $set_new['has_jewels'];
                $set->has_weapons      = $set_new['has_weapons'];
                $set->has_heavy_armor  = $set_new['has_heavy_armor'];
                $set->has_light_armor  = $set_new['has_light_armor'];
                $set->has_medium_armor = $set_new['has_medium_armor'];
                $set->traits_needed    = $set_new['traits_needed'];
                $set->order            = random_int(1, 999999);
                $set->save();
            } else {
                $db->name             = $set_new['name'];
                $db->location         = $set_new['location'];
                $db->type             = $set_new['type'];
                $db->slug             = $set_new['slug'];
                $db->bonus_item_1     = $set_new['bonus_item_1'];
                $db->bonus_item_2     = $set_new['bonus_item_2'];
                $db->bonus_item_3     = $set_new['bonus_item_3'];
                $db->bonus_item_4     = $set_new['bonus_item_4'];
                $db->bonus_item_5     = $set_new['bonus_item_5'];
                $db->has_jewels       = $set_new['has_jewels'];
                $db->has_weapons      = $set_new['has_weapons'];
                $db->has_heavy_armor  = $set_new['has_heavy_armor'];
                $db->has_light_armor  = $set_new['has_light_armor'];
                $db->has_medium_armor = $set_new['has_medium_armor'];
                $db->traits_needed    = $set_new['traits_needed'];
                $db->save();
            }
        }

        return true;
    }
}
