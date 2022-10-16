<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;

class ParseSaveFile
{
    public array $words = [
        'quest_list',
        'temple_data',
        'weapon_equip',
        'corrupted_slorm',
        'pure_slorm',
        'stats_fetched',
        'level_cap_previous',
        'version',
        'reaper_affinity',
        'temple_upgrades',
        'update_refund',
        'slormite_list',
        'shared_inventory',
        'first_hero',
        'weapon_data',
        'gamemode',
        'skill_equip',
        'hero',
        'missions',
        'temple_blessing',
        'date',
        'store_refresh_list',
        'traits',
        'reputation',
        'wrath',
        'skill_rank',
        'reaper_pity',
        'reaper_runes',
        'gold',
        'xp',
        'mission_match',
        'inventory',
        'slorm',
        'influence',
        'element_equip',
        'tutorials',
        'ultimatums',
        'equipment_list',
        'filter',
        'element_rank',
        'enemy_match',
        'auras',
        'profile',
        'enemy_level',
    ];

    /**
     * Parse the given save file.
     *
     * @param  UploadedFile $file
     * @return array
     */
    public function execute(UploadedFile $file): array
    {
        [$content, $hash] = str($file->getContent())->explode('#');

        $data = $this->parseKeys($content);

        $data['levels'] = str($data['xp'])->explode('|')->map(function ($xp) {
            return $this->getLevelByXP($xp);
        });

        return $data;
    }
    
    /**
     * Return the save file data keyed by human-readable words.
     *
     * @param  string $content
     * @return array
     */
    private function parseKeys(string $content): array
    {
        $content = str($content)->lower();

        $keys = [];

        foreach ($this->words as $index => $word) {
            $firstWord = unpack('H*', $this->words[$index])[1];

            $isAnotherWord = !empty($this->words[$index + 1]);

            if ($isAnotherWord) {
                $nextWord = unpack('H*', $this->words[$index + 1])[1];
                $data = hex2bin($content->betweenFirst($firstWord, $nextWord));
            } else {
                $data = hex2bin($content->after($firstWord));
            }

            $keys[$word] = str($data)
                ->trim()
                ->matchAll('/[a-zA-Z0-9|.?]/')
                ->join('');

            /**
             * Remove the save file content we've already read to avoid duplicates.
             * For example, hero and first_hero or weapon_equip and weapon_data.
             */
            $content = $content->after($firstWord);
        }

        return $keys;
    }

    protected function getLevelByXP(int $xp): int
    {
        $xpAmounts = config('xp_amounts');

        $level = 1;

        foreach ($xpAmounts as $nextLevel) {
            if ($xp >= $nextLevel) {
                $level++;
            } else {
                return $level;
            }
        }

        return $level;
    }
}