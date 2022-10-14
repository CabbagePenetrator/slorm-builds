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

    public string $content;

    public function execute(UploadedFile $file)
    {
        $this->content = $file->getContent();

        [$content, $hash] = str($this->content)->explode('#');

        $this->parseKeys(str($content)->lower());
    }

    private function parseKeys($content): array
    {
        $keys = [];

        foreach ($this->words as $index => $word) {
            // [hero,first_hero]
            $firstWord = unpack('H*', $this->words[$index])[1];

            if (empty($this->words[$index + 1])) {
                $data = hex2bin($content->after($firstWord));
            } else {
                $nextWord = unpack('H*', $this->words[$index + 1])[1];
                $data = hex2bin($content->betweenFirst($firstWord, $nextWord));
            }

            $keys[$word] = str($data)->trim()->replaceMatches('/^.+\s{2,}/', '');

            $content = $content->after($firstWord);
        }

        return $keys;
    }
}